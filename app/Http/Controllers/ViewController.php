<?php

namespace App\Http\Controllers;

use App\Services\Errors;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

class ViewController extends Controller
{
    /**
     * Render index view
     *
     * @return [response] view
     */
    public function index(Request $request)
    {
        $images = $this->images($request);
        
        $authors = app(User::class)
            ->where(['permission' => User::PERMISSION_WRITE])
            ->orWhere(['permission' => User::PERMISSION_ADMIN])
            ->get();
        
        return $this->main($request, view('index', [
            'is_expand' => $request->session()->has('token'),
            'is_admin' => $request->session()->get('permission') === User::PERMISSION_ADMIN,
            'is_write' => $request->session()->get('permission') === User::PERMISSION_WRITE,
            'query' => [
                'tag' => $request->input('tag'),
                'author' => $request->input('author')
            ],
            'images' => $images['data'],
            'count' => $images['count'],
            'url' => $request->root(),
            'tags' => app(Tag::class)->all(),
            'authors' => $authors,
            'download_box' => $this->downloadBox($request)
        ]));
    }

    /**
     * Render upload view
     *
     * @return [response] view
     */
    public function upload(Request $request)
    {
        return $this->main($request, view('upload', [
            'token' => $request->session()->get('token'),
            'permission' => $request->session()->get('permission')
        ]));
    }

    /**
     * Render adminUploadValidationCode view
     *
     * @return [response] view
     */
    public function adminUploadValidationCode(Request $request)
    {
        return $this->main($request, view('admin/upload-validation-code', [
            'token' => $request->session()->get('token'),
            'permission' => $request->session()->get('permission')
        ]));
    }

    /**
     * Render main
     *
     * @return [response] view
     */
    public function main($request, $view)
    {
        return view('main', [
            'url' => $request->root(),
            'uri' => $request->path(),
            'token' => $request->session()->get('token'),
            'permission' => $request->session()->get('permission'),
            'login' => $this->login($request),
            'register' => $this->register($request),
            'header' => $this->header($request),
            'custom' => $view
        ]);
    }

    // components

    /**
     * Render header
     *
     * @return [response] view
     */
    private function header($request)
    {
        return view('component/header', [
            'token' => $request->session()->get('token'),
            'permission' => $request->session()->get('permission'),
            'user' => $request->user(),
            'url' => $request->root(),
            'uri' => $request->path(),
            'imageCount' => app(Image::class)->count()
        ]);
    }

    /**
     * Render login
     *
     * @return [response] view
     */
    private function login($request)
    {
        if ($request->session()->get('token') === null) {
            return view('component/login', [
                'url' => $request->root()
            ]);
        }
    }

    /**
     * Render register
     *
     * @return [response] view
     */
    private function register($request)
    {
        if ($request->session()->get('token') === null) {
            return view('component/register', [
                'url' => $request->root()
            ]);
        }
    }

    /**
     * Render image card
     *
     * @return [response] view
     */
    private function images($request)
    {
        if ($request->session()->get('token') === null) {
            return app(ImageController::class)->visitorView($request);
        } else {
            return app(ImageController::class)->userView($request);
        }
    }

    /**
     * Render download image card
     *
     * @return [response] view
     */
    private function downloadBox($request)
    {
        if ($request->session()->get('token') != null) {
            return view('component/download_box', []);
        }
    }
}