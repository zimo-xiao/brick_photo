<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller as BaseController;
use Ixudra\Curl\Facades\Curl;
use Keygen\Keygen;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    public function user($request)
    {
        $token = $request->session()->get('token');
        if ($token != null) {
            try {
                if (\Cache::store('redis')->has('user_info_'.$token)) {
                    $out = json_decode(\Cache::store('redis')->get('user_info_'.$token));
                } else {
                    $out = Curl::to($request->root().'/auth')
                        ->withHeader('Authorization: Bearer '.$token)
                        ->asJson()
                        ->get();
                    \Cache::store('redis')->put(json_encode($out), 'user_info_'.$token, 5);
                }
                // HACK: 测试用户是否存在，故意报错
                $out->permission;
                return $out;
            } catch (\Exception $e) {
                $request->session()->forget('token');
                \Cache::store('redis')->delete('user_info_'.$token);
                return json_decode(json_encode([
                    'name' => null,
                    'permission' => null,
                    'id' => null,
                    'usin' => null
                ]));
            }
        } else {
            return json_decode(json_encode([
                'name' => null,
                'permission' => null,
                'id' => null,
                'usin' => null
            ]));
        }
    }

    public function generateNumericKey()
    {
        return Keygen::numeric(8)->prefix(mt_rand(1, 9))->generate(true);
    }

    public function responseImageFromPath($path, $dir, $image)
    {
        $path = $path.'/'.$dir.'/'.$image;
        if (!File::exists($path)) {
            return response()->json([
                'error_msg' => '图片不存在'
            ], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        return (new Response($file, 200))->header('Content-Type', $type);
    }

    private function isValid($string)
    {
        json_decode($string, true);
        return isset($string['id']);
    }
}