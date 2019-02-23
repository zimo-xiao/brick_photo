<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Image;
use App\Models\User;
use App\Jobs\StoreNewImageJob;

class ImageController extends Controller
{
    /**
     * Upload an image piece by piece
     *
     * @return [response] view
     */
    public function upload(Request $request)
    {
        // 图片片段信息
        $end = $request->input('end');
        $file = $request->input('file');
        $total = $request->input('total');
        $index = $request->input('index');
        $name = $request->input('name');
        $user = $request->user();

        // 权限
        if ($user->permission != User::PERMISSION_WRITE && $user->permission != User::PERMISSION_ADMIN) {
            return response()->json([
                'error_msg' => '你没有权限上传图片'
            ], 401);
        }

        // 去重
        if (count(app(Image::class)->where([
            'file_name' => $name
        ])->get()) > 0) {
            // 如果图片已经上传，就不要管他了
            return;
        }

        // 系统信息
        $pubDir = \public_path();
        $imageDir = \env('IMAGE_DIR');
        $tempImg = $pubDir.'/'.$imageDir.'/tmp/'.$name.'.tmp';

        // 储存图片片段
        if ($index == 0) {
            if (!(\file_put_contents($tempImg, $file))) {
                return 'instruction:again';
            }
        } else {
            if (!(\file_put_contents($tempImg, $file, FILE_APPEND))) {
                return 'instruction:again';
            }
        }
        
        if ($total == ($index + 1)) {
            dispatch(new StoreNewImageJob($end, $total, $index, $name, $user));
        }
    }

    /**
     * Process an image in queue
     */
    public function store($end, $total, $index, $name, $user)
    {
        // 系统信息
        $pubDir = \public_path();
        $imageDir = \env('IMAGE_DIR');
        $tempImg = $pubDir.'/'.$imageDir.'/tmp/'.$name.'.tmp';

        // 如果传输到结尾了
        // 分割文件
        $inputData = \explode('#**#', \file_get_contents($tempImg));
        // 在文件中提取出预览图和原图
        $cache = \base64_decode(substr($inputData[0], \strpos($inputData[0], ',') + 1));
        $raw = \base64_decode(substr($inputData[1], \strpos($inputData[1], ',') + 1));
        // 上传目录
        $rawImgDir = $pubDir.'/'.$imageDir.'/raw/'.$name.'.'.$end;
        $cacheImgDir = $pubDir.'/'.$imageDir.'/cache/'.$name.'.jpg';
        // 上传文件
        if (file_put_contents($rawImgDir, $raw) && file_put_contents($cacheImgDir, $cache)) {
            // 删除临时文件
            unlink($tempImg);
        }
        // index
        app(Image::class)->insertTs([
            'author_id' => $user->id,
            'author_name' => $user->name,
            'file_name' => $name,
            'file_format' => $end
        ]);
    }

    /**
     * View image with the permission of user
     *
     * @return [response] view
     */
    public function userView(Request $request)
    {
        $author = null;
        $tag = null;
        $page = 1;
        $perPage = 40;
        if ($request->has('author')) {
            $author = $request->input('author');
        }
        if ($request->has('tag')) {
            $tag = $request->input('tag');
        }
        if ($request->has('page')) {
            $page = $request->input('page');
        }
        return $this->view($page, $perPage, $author, $tag);
    }

    /**
     * View image with the permission of visitors
     *
     * @return [response] view
     */
    public function visitorView(Request $request)
    {
        return $this->view(1, 9999999, $author = null, $tag = null);
    }

    /**
     * Get image from query
     *
     * @return
     */
    private function view($page, $perPage, $author = null, $tag = null)
    {
        $skip = ($page - 1) * $perPage;
        
        $image = app(Image::class);
        if ($author != null) {
            $image->where('author', 'LIKE', $author);
        }
        return $image->orderBy('updated_at', 'desc')->skip($skip)->take($perPage)->get();
    }
}