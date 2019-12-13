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
                if ($user = $request->session()->get('user_info')) {
                    $out = json_decode($user);
                } else {
                    $out = Curl::to(\env('APP_URL').'/auth')
                        ->withHeader('Authorization: Bearer '.$token)
                        ->asJson()
                        ->withTimeout(10)
                        ->get();
                    $request->session()->put('user_info', json_encode($out), 5);
                }
                // HACK: 测试用户是否存在，故意报错
                $out->permission;
                return $out;
            } catch (\Exception $e) {
                $request->session()->forget('access_token');
                $request->session()->forget('user_info');
                // to obj
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

    public function responseImageFromPath($path, $dir, $image, $error = 'image not exists')
    {
        $isCloud = strpos($path, 'https://') !== false;
        $path = $dir.'/'.$image;

        if ($isCloud) {
            try {
                $file = $this->file->get($path);
                $type = strpos($path, 'png') !== false ? 'image/png': 'image/jpeg';
            } catch (\Exception $e) {
                return response()->json([
                    'error_msg' => $error
                ], 404);
            }
        } else {
            if (!File::exists($path)) {
                return response()->json([
                    'error_msg' => $error
                ], 404);
            }
            $file = File::get($path);
            $type = File::mimeType($path);
        }
        return (new Response($file, 200))->header('Content-Type', $type);
    }

    public function deleteGlobalCache()
    {
        \Cache::store('redis')->delete('header_counter');
        \Cache::store('redis')->delete('index_sidebar');
    }

    private function isValid($string)
    {
        json_decode($string, true);
        return isset($string['id']);
    }
}