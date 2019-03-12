<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ValidationCode;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AuthController extends Controller
{
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
        
        $usin = $request->input('usin');
        $password = $request->input('password');

        $code = $request->input('code');

        $validation = app(ValidationCode::class)->where(['code' => $code,'usin' => $usin])->get();
        if (count($validation) === 0) {
            return response()->json([
                'error_msg' => '激活码错误'
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
                'error_msg' => '该学号已被注册'
            ], 401);
        }
                
        app(ValidationCode::class)->where(['code' => $code,'usin' => $usin])->delete();

        $user = $this->validateLogin($usin, $password);
        if (!$user) {
            return response()->json([
                'error_msg' => '用户验证错误'
            ], 401);
        }

        $token = $this->createAccessToken($user);
        $request->session()->put('token', $token['access_token']);
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
        $usin = $request->input('usin');
        
        $user = $this->validateLogin($usin, $password);
        if (!$user) {
            return response()->json([
                'error_msg' => '用户名或密码错误'
            ], 401);
        }
        
        $token = $this->createAccessToken($user);
        $request->session()->put('token', $token['access_token']);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $token = $request->session()->get('token');
        \Cache::store('redis')->delete($token);
        $request->user()->token()->revoke();
        $request->session()->forget('token');
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
                if ($sendPhotographerEmail) {
                    dispatch(new SendMailJob($user['email'], $this->welcomeEmailText($user['name'])));
                }
            } else {
                return response()->json([
                    'error_msg' => '该用户不存在'
                ], 401);
            }
        } else {
            return response()->json([
                'error_msg' => '操作用户'
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

        $usin = $request->input('usin');
        $user = app(User::class)->where(['usin' => $usin])->limit(1)->get();
        if (count($user) > 0) {
            $user = $user[0];

            $code = 'pass_'.$this->generateNumericKey();
            while (\Cache::store('redis')->has($code)) {
                $code = 'pass_'.$this->generateNumericKey();
            }
            \Cache::store('redis')->put($code, $user['id'], 60);

            dispatch(new SendMailJob($user['email'], $this->emailText($user['name'], $code, $request->root())));
        } else {
            return response()->json([
                'error_msg' => '该用户不存在'
            ], 401);
        }
    }

    public function export(Request $request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            $codes = app(User::class)->all();
            return Excel::create('所有用户信息', function ($excel) use ($codes) {
                $excel->sheet('Sheet 1', function ($sheet) use ($codes) {
                    unset($codes['password']);
                    $sheet->fromArray($codes);
                });
            })->export('xls');
        } else {
            return '你没有权限';
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
                'error_msg' => '验证出错'
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
        $query = app(User::class)->where([
            'usin' => $usin,
            'password' => $this->encrypt($password)
        ])->limit(1)->get();

        if (count($query) > 0) {
            return app(User::class)->find($query[0]['id']);
        } else {
            return false;
        }
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
            'description' => '请点击以下链接找回密码（50分钟内有效）：'.$url.'/reset-password/'.$code,
            'title' => '找回密码邮件'
        ];
    }

    private function welcomeEmailText($name)
    {
        return [
            'name' => $name,
            'description' => "恭喜你成为红砖摄影师，现在传图权限已经为你开启啦！\n\n\n请退出账号重新登陆,传图等功能已为您开启，如遇到任何问题请及时联系我们。期待你可以把自己满意的作品传到红砖，为附中增添一份宝藏！如果在传图的过程中遇到问题，或者你有大量传图的需求，欢迎联系我们（微信：lrh20021108），我们会第一时间给予支持！",
            'title' => '欢迎！摄影师！'
        ];
    }
}