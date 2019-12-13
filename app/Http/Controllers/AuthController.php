<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ValidationCode;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\ExportUsers;
use App\Services\Apps;

class AuthController extends Controller
{
    protected $intl;

    public function __construct()
    {
        $this->intl = app(Apps::class)->intl()['authController'];
    }

    /**
     * Register user
     *
     * @param  [string] usin
     * @param  [string] activation_code
     * @param  [string] password
     * @return [response] token_info
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'usin' => 'required',
            'code' => 'required',
            'password' => 'required|string'
        ]);
        
        $usin = strtolower($request->input('usin'));
        $password = $request->input('password');

        $code = $request->input('code');

        $validation = app(ValidationCode::class)->where(['code' => $code])->whereRaw('LOWER(usin) = ?', [$usin])->get();
        if (count($validation) === 0) {
            return response()->json([
                'error_msg' => $this->intl['validationCodeError']
            ], 401);
        }

        $credentials = [
            'usin' => $usin,
            'password' => $this->encrypt($password),
            'name' => $validation[0]['name'],
            'permission' => User::PERMISSION_READ,
            'email' => $validation[0]['email']
        ];

        try {
            $user = new User($credentials);
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error_msg' => $this->intl['usinExists']
            ], 401);
        }
                
        app(ValidationCode::class)->where(['code' => $code])->whereRaw('LOWER(usin) = ?', [$usin])->delete();

        $user = $this->validateLogin($usin, $password);
        if (!$user) {
            return response()->json([
                'error_msg' => $this->intl['validationError']
            ], 401);
        }

        $this->deleteGlobalCache();
        $token = $this->createAccessToken($user);
        $request->session()->put('access_token', $token['access_token']);
        $request->session()->put('permission', $user->permission);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] usin
     * @param  [string] password
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string',
            'usin' => 'required|string'
        ]);

        $password = $request->input('password');
        $usin = strtolower($request->input('usin'));
        
        $user = $this->validateLogin($usin, $password);
        if (!$user) {
            return response()->json([
                'error_msg' => $this->intl['passOrUsinError']
            ], 401);
        }
        
        $token = $this->createAccessToken($user);
        $request->session()->put('access_token', $token['access_token']);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $token = $request->session()->get('access_token');
        \Cache::store('redis')->delete('user_info_'.$token);
        $request->user()->token()->revoke();
        $request->session()->forget('access_token');
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Update user info
     *
     * @return [string] message
     */
    public function updateByUsin(Request $request, $id)
    {
        $this->validate($request, [
            'permission' => 'required'
        ]);

        if ($request->user()->permission === User::PERMISSION_ADMIN) {
            $user = app(User::class)->where(['usin' => $id])->get();
            if (count($user) > 0) {
                $user = $user[0];
                $sendPhotographerEmail = false;
                $update = [];
                if ($request->has('permission')) {
                    $update['permission'] = $request->input('permission');
                    if ($update['permission'] == User::PERMISSION_WRITE) {
                        $sendPhotographerEmail = true;
                    }
                }
                app(User::class)->where(['usin' => $id])->limit(1)->updateTs($update);
                $this->deleteGlobalCache();
                if ($sendPhotographerEmail) {
                    dispatch(new SendMailJob($user['email'], $this->welcomeEmailText($user['name'])));
                }
            } else {
                return response()->json([
                    'error_msg' => $this->intl['userNotExists']
                ], 401);
            }
        } else {
            return response()->json([
                'error_msg' => $this->intl['permissionDenied']
            ], 401);
        }
    }
  
    /**
     * Get the authenticated User
     *
     * @return [response] user
     */
    public function view(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Get the authenticated User
     *
     * @return [response] user
     */
    public function findPassword(Request $request)
    {
        $this->validate($request, [
            'usin' => 'required'
        ]);

        $usin = strtolower($request->input('usin'));
        $user = app(User::class)->whereRaw('LOWER(usin) = ?', [$usin])->limit(1)->get();
        if (count($user) > 0) {
            $user = $user[0];

            $code = 'pass_'.$this->generateNumericKey();
            while (\Cache::store('redis')->has($code)) {
                $code = 'pass_'.$this->generateNumericKey();
            }
            \Cache::store('redis')->put($code, $user['id'], 60);

            dispatch(new SendMailJob($user['email'], $this->emailText($user['name'], $code, \env('APP_URL'))));
        } else {
            return response()->json([
                'error_msg' => $this->intl['userNotExists']
            ], 401);
        }
    }

    public function export(Request $request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            return Excel::download(new ExportUsers, $this->intl['allUserInfo'].'.xlsx');
        } else {
            return $this->intl['permissionDenied'];
        }
    }

    /**
     * Render upload view
     *
     * @return [response] view
     */
    public function resetPassword(Request $request, $code)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);

        if (\Cache::store('redis')->has($code)) {
            $id = \Cache::store('redis')->get($code);
            $user = app(User::class)->find($id);
            $password = $request->input('password');
            $user->password = $this->encrypt($password);
            $user->save();
            \Cache::store('redis')->delete($code);
        } else {
            return response()->json([
                'error_msg' => $this->intl['validationError']
            ], 401);
        }
    }

    /**
     * Login validation
     *
     * @param  [string] usin
     * @param  [string] password
     * @return [mix] false/user model
     */
    private function validateLogin($usin, $password)
    {
        $usin = strtolower($usin);
        return app(User::class)->where(['password' => $this->encrypt($password)])->whereRaw('LOWER(usin) = ?', [$usin])->limit(1)->first();
    }
    
    /**
     * Create access token from auth state
     *
     * @param  [object] user
     * @return [array] token_info
     */
    private function createAccessToken($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        // 延长token过期时间
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(10);
        $token->save();
        
        return [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ];
    }

    /**
     * Encrypt password
     *
     * @param  [string] password
     * @return [string] hashed_password
     */
    private function encrypt($password)
    {
        return md5($password);
    }

    private function emailText($name, $code, $url)
    {
        return [
            'name' => $name,
            'description' => str_replace('[url]', $url.'/reset-password/'.$code, $this->intl['email']['resetPass']['description']),
            'title' => $this->intl['email']['resetPass']['title']
        ];
    }

    private function welcomeEmailText($name)
    {
        return [
            'name' => $name,
            'description' => $this->intl['email']['welcome']['description'],
            'title' => $this->intl['email']['welcome']['title']
        ];
    }
}