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
            $value = \Cache::store('redis')->get($token);
            if (\Cache::store('redis')->has($token) && $this->isValid($value)) {
                return json_decode($value);
            } else {
                $data = Curl::to($request->root().'/auth')
                    ->withHeader('Authorization: Bearer '.$token)
                    ->asJson()
                    ->get();
                \Cache::store('redis')->put($token, json_encode($data), 60);
                return $data;
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