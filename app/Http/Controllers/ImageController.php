<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Download;
use App\Models\Delete;
use Illuminate\Http\Request;
use App\Jobs\StoreNewImageJob;
use App\Jobs\SendMailJob;
use App\Services\Apps;
use App\Services\Files;

class ImageController extends Controller
{
    protected $intl;

    protected $file;

    public function __construct()
    {
        $this->intl = app(Apps::class)->intl()['imageController'];
        $this->file = new Files(\env('APP_FILE_SYSTEM'));
    }

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

        $end = $request->input('end');
        $file = $request->input('file');
        $total = $request->input('total');
        $index = $request->input('index');
        $name = $request->input('name');
        $user = $request->user();

        if ($user->permission != User::PERMISSION_WRITE && $user->permission != User::PERMISSION_ADMIN) {
            return response()->json([
                'error_msg' => $this->intl['permissionDenied']
            ], 401);
        }

        // avoid duplication
        if (app(Image::class)->where(['file_name' => $name])->first()) {
            return;
        }

        try {
            $this->file->upload($name, $index, $file);
        } catch (\Exception $e) {
            return 'instruction:again';
        }

        if ($total == ($index + 1)) {
            $this->deleteGlobalCache();
            dispatch(new StoreNewImageJob($name, $end, $user));
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
        $orderBy = 'created_desc';
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
        return $this->view($page, $perPage, $author = null, $tag = $this->intl['visitorViewTag'], 'update_desc');
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
                if (\in_array($this->intl['visitorViewTag'], $tags) && $request->user()->permission != User::PERMISSION_ADMIN) {
                    $tags = array_filter($tags, function ($a) {
                        return $a != $this->intl['visitorViewTag'];
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
                'error_msg' => $this->intl['permissionDenied']
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

            app(Delete::class)->insertTs([
                'image_id' => $image->id,
                'author_id' => $image->author_id,
                'reason' => $request->input('reason')
            ]);

            $image->delete();
            $this->deleteGlobalCache();
        } else {
            return response()->json([
                'error_msg' => $this->intl['permissionDenied']
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
                'error_msg' => $this->intl['permissionDenied']
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
                'error_msg' => $this->intl['imgNotExits']
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
}