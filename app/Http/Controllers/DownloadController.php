<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\File;

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
            if ($user->permission === User::PERMISSION_ADMIN) {
                return $this->responseImageFromPath($imageDir, 'raw', $img);
            } else {
                $path = $imageDir.'/watermark/'.$img;
                if (!File::exists($path)) {
                    return '水印还在生成中，请过10分钟后再来下载';
                }
                return $this->responseImageFromPath($imageDir, 'watermark', $img);
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
}