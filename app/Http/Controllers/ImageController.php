<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Download;
use Illuminate\Http\Request;
use App\Jobs\StoreNewImageJob;
use App\Jobs\StoreWatermarkJob;
use App\Jobs\SendMailJob;

class ImageController extends Controller
{
    /**
     * Upload an image piece by piece
     *
     * @return [response] view
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'end' => 'required',
            'file' => 'required',
            'total' => 'required',
            'index' => 'required',
            'name' => 'required'
        ]);

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
        $imageDir = \env('IMAGE_DIR');
        $tempImg = $imageDir.'/tmp/'.$name.'.tmp';

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
        $imageDir = \env('IMAGE_DIR');
        $tempImg = $imageDir.'/tmp/'.$name.'.tmp';

        // 如果传输到结尾了
        // 分割文件
        $inputData = \explode('#**#', \file_get_contents($tempImg));
        // 在文件中提取出预览图和原图
        $cache = \base64_decode(substr($inputData[0], \strpos($inputData[0], ',') + 1));
        $raw = \base64_decode(substr($inputData[1], \strpos($inputData[1], ',') + 1));
        // 上传目录
        $rawImgDir = $imageDir.'/raw/'.$name.'.'.$end;
        $cacheImgDir = $imageDir.'/cache/'.$name.'.jpg';
        // 上传文件
        if (file_put_contents($rawImgDir, $raw) && file_put_contents($cacheImgDir, $cache)) {
            // 删除临时文件
            unlink($tempImg);

            // index
            app(Image::class)->insertTs([
                'author_id' => $user->id,
                'author_name' => $user->name,
                'file_name' => $name,
                'file_format' => $end,
                'tags' => json_encode([]),
                'path' => $imageDir
            ]);

            $this->deleteGlobalCache();

            dispatch(new StoreWatermarkJob($name.'.'.$end));
        }
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
        $orderBy = 'update_desc';
        if ($request->has('author')) {
            $author = $request->input('author');
        }
        if ($request->has('tag')) {
            $tag = $request->input('tag');
        }
        if ($request->has('page')) {
            $page = $request->input('page');
        }
        if ($request->has('order')) {
            $orderBy = $request->input('order');
        }
        return $this->view($page, $perPage, $author, $tag, $orderBy);
    }

    /**
     * View image with the permission of visitors
     *
     * @return [response] view
     */
    public function visitorView(Request $request)
    {
        $page = 1;
        $perPage = 40;
        if ($request->has('page')) {
            $page = $request->input('page');
        }
        return $this->view($page, $perPage, $author = null, $tag = '编辑推荐', 'update_desc');
    }

    /**
     * Update image info
     *
     * @return [response] view
     */
    public function update(Request $request, $id)
    {
        $image = app(Image::class)->find($id);

        if ($image->author_id === $request->user()->id || $request->user()->permission === User::PERMISSION_ADMIN) {
            if ($request->has('tags')) {
                $tags = $request->input('tags');
                // 如果不是admin，则不能设置编辑推荐
                if (\in_array('编辑推荐', $tags) && $request->user()->permission != User::PERMISSION_ADMIN) {
                    $tags = array_filter($tags, function ($a) {
                        return $a != '编辑推荐';
                    });
                }
                $image->tags = json_encode($tags);
            }

            if ($request->has('description')) {
                $image->description = $request->input('description');
            }

            $image->save();
        } else {
            return response()->json([
                'error_msg' => '你没有权限修改图片'
            ], 401);
        }
    }

    /**
     * Delete image
     *
     * @return [response] view
     */
    public function delete(Request $request, $id)
    {
        $this->validate($request, [
            'reason' => 'required'
        ]);

        if ($request->user()->permission === User::PERMISSION_ADMIN) {
            $image = app(Image::class)->find($id);
            $user = app(User::class)->find($image->author_id);
            $input = [
                'email' => $user->email,
                'image_id' => $image->id,
                'name' => $user->name,
                'reason' => $request->input('reason')
            ];

            $image->delete();
            $this->deleteGlobalCache();

            dispatch(new SendMailJob($input['email'], $this->emailText($input)));
        } else {
            return response()->json([
                'error_msg' => '你没有权限删除图片'
            ], 401);
        }
    }

    /**
     * Delete image
     *
     * @return [response] view
     */
    public function deleteBatch(Request $request, $from, $to)
    {
        if ($request->user()->permission === User::PERMISSION_ADMIN) {
            app(Image::class)->whereBetween('id', [$from, $to])->delete();
            $this->deleteGlobalCache();
        } else {
            return response()->json([
                'error_msg' => '你没有权限删除图片'
            ], 401);
        }
    }

    public function viewImageCache(Request $request, $id)
    {
        $image = app(Image::class)->find($id);
        if ($image) {
            return $this->responseImageFromPath($image->path, 'cache', $image->file_name.'.jpg');
        } else {
            return response()->json([
                'error_msg' => '图片不存在'
            ], 404);
        }
    }

    /**
     * Get image from query
     *
     * @return
     */
    private function view($page, $perPage, $author = null, $tag = null, $orderBy = 'update_desc')
    {
        $skip = ($page - 1) * $perPage;
        $data = $this->initModel($author, $tag);

        if ($orderBy == 'update_desc') {
            $data = $data->orderBy('updated_at', 'desc');
        } elseif ($orderBy == 'update_asc') {
            $data = $data->orderBy('updated_at', 'asc');
        } elseif ($orderBy == 'created_desc') {
            $data = $data->orderBy('created_at', 'desc');
        } elseif ($orderBy == 'created_asc') {
            $data = $data->orderBy('created_at', 'asc');
        }
        
        $data = $data->skip($skip)->take($perPage)->get();
        
        // 计算count
        $query = [];
        foreach ($data as $d) {
            $query[$d['id']] = ['image_id' => $d['id']];
        }
        
        $downloadCount = app(Download::class)->rawMultipleCounts($query, function ($model) {
            return $model;
        });

        foreach ($data as $k => $d) {
            $data[$k]['tag'] = json_decode($d['tags'], true);
            $data[$k]['download_count'] = $downloadCount[$d['id']] ?? 0;
        }

        return [
            'data' => $data,
            'count' => $this->initModel($author, $tag)->count()
        ];
    }

    /**
     * Init image model
     *
     * @return
     */
    private function initModel($author, $tag)
    {
        $image = app(Image::class)->select(['id', 'author_id', 'author_name', 'tags', 'description']);
        if ($author != null) {
            $image = $image->where(['author_id' => $author]);
        }
        if ($tag != null) {
            $image = $image->where('tags', 'LIKE', '%'.$tag.'%');
        }
        return $image;
    }

    private function emailText($input)
    {
        return [
            'name' => $input['name'],
            'description' => "您的编号为**".$input['image_id']."**的图片被管理员删除\n\n原因：".$input['reason'],
            'title' => '图片删除通知',
            'url' => \env('APP_URL')
        ];
    }
}