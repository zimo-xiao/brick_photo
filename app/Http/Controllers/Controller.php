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
        $token = $request->session()->get('access_token');
        if ($token != null) {
            try {
                if (\Cache::store('redis')->has('user_info_'.$token)) {
                    $out = json_decode(\Cache::store('redis')->get('user_info_'.$token));
                } else {
                    $out = Curl::to(\env('APP_URL').'/auth')
                        ->withHeader('Authorization: Bearer '.$token)
                        ->asJson()
                        ->get();
                    \Cache::store('redis')->put(json_encode($out), 'user_info_'.$token, 5);
                }
                // HACK: 测试用户是否存在，故意报错
                $out->permission;
                return $out;
            } catch (\Exception $e) {
                throw $e;
                $request->session()->forget('access_token');
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
                'error_msg' => 'image not exists'
            ], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        return (new Response($file, 200))->header('Content-Type', $type);
    }

    public function deleteGlobalCache()
    {
        \Cache::store('redis')->delete('header_counter');
        \Cache::store('redis')->delete('index_sidebar');
    }
    
    public function blurText($input, $save = 1)
    {
        $blurLen = mb_strlen($input) - $save;

        return mb_substr($input, 0, $save).str_repeat('*', $blurLen);
    }

    private function isValid($string)
    {
        json_decode($string, true);
        return isset($string['id']);
    }
}
