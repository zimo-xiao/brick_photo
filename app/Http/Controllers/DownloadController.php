<?php

namespace App\Http\Controllers;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;
use App\Models\Download;
use Keygen\Keygen;
use App\Models\User;
use App\Models\Image;
use App\Jobs\SendMailJob;

class DownloadController extends Controller
{
    public function view(Request $request, $id)
    {
        $this->validate($request, [
            'usage' => 'required'
        ]);

        $usage = $request->input('usage');
        $image = app(Image::class)->find($id);
        if (!$image) {
            return response()->json([
                'error_msg' => '图片不存在'
            ], 401);
        }
        $author = app(User::class)->find($image['author_id']);

        app(Download::class)->insert([
            'downloader_id' => $request->user()->id,
            'downloader_name' => $request->user()->name,
            'image_id' => $id,
            'usage' => $usage
        ]);

        dispatch(new SendMailJob($author['email'], $this->emailText($author['name'], $request->user()->name, $id, $usage)));

        $code = $this->generateNumericKey();
        while (\Cache::store('redis')->has($code)) {
            $code = $this->generateNumericKey();
        }
        \Cache::store('redis')->put($code, $image->file_name.'.'.$image->file_format, 5);
        
        return response()->json([
            'code' => $code
        ]);
    }

    public function action(Request $request, $code)
    {
        if (\Cache::store('redis')->has($code)) {
            $img = \Cache::store('redis')->get($code);
            \Cache::store('redis')->delete($code);

            $user = $this->user($request);
            $imageDir = \env('IMAGE_DIR');
            $pubDir = \public_path();
            if ($user->permission === User::PERMISSION_ADMIN) {
                $rawImg = $pubDir.'/'.$imageDir.'/raw/'.$img;
                return response()->download($rawImg);
            } else {
                $watermarkImage = $pubDir.'/'.$imageDir.'/watermark/'.$img;
                return response()->download($watermarkImage);
            }
        } else {
            return '下载过期';
        }
    }

    private function emailText($authorName, $downloaderName, $imageId, $usage)
    {
        return [
            'name' => $authorName,
            'description' => '你的编号为**'.$imageId.'**的图片，被'.$downloaderName.'下载，用途为：**'.$usage.'**',
            'title' => '下载图片提醒'
        ];
    }

    private function generateNumericKey()
    {
        return Keygen::numeric(8)->prefix(mt_rand(1, 9))->generate(true);
    }

    /**
     * Get user data from token
     *
     * @return [response] view
     */
    private function user($request)
    {
        $token = $request->session()->get('token');
        if ($request->session()->get('token') != null) {
            if (\Cache::store('redis')->has($token)) {
                return json_decode(\Cache::store('redis')->get($token));
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
}