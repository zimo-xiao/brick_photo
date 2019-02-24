<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ValidationCode;
use Illuminate\Support\Facades\Auth;

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
        $request->session()->put('permission', $user->permission);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $request->session()->forget('token');
        $request->session()->forget('permission');
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Update user info
     *
     * @return [string] message
     */
    public function update(Request $request)
    {
        $update = [];
        if ($request->has('password')) {
            $update['password'] = $this->encrypt($request->input('password'));
        }

        $request->user()->updateTs($update);

        return response()->json([
            'message' => 'Successfully updated'
        ]);
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
}