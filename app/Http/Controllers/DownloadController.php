<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

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

        app(Download::class)->insertTs([
            'downloader_id' => $request->user()->id,
            'downloader_name' => $request->user()->name,
            'image_id' => $id,
            'usage' => $usage
        ]);

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

    public function export(Request $request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            $users = app(Download::class)->all();
            return Excel::create('下载动态信息', function ($excel) use ($users) {
                $excel->sheet('Sheet 1', function ($sheet) use ($users) {
                    $sheet->fromArray($users);
                });
            })->export('xls');
        } else {
            return '你没有权限';
        }
    }
}