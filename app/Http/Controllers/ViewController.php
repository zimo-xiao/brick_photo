<?php

namespace App\Http\Controllers;

use App\Services\Errors;
use App\Http\Controllers\ImageController;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\User;

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
        $user = $this->user($request);
        $sidebar = $this->getSidebarData();
        return $this->main($request, view('index', [
            'token' => $request->session()->get('token'),
            'user' => $user,
            'query' => [
                'tag' => $request->input('tag'),
                'author' => $request->input('author'),
                'order' => $request->input('order')
            ],
            'images' => $images['data'],
            'count' => $images['count'],
            'url' => $request->root(),
            'tags' => $sidebar['tags'],
            'authors' => $sidebar['authors'],
            'admins' => $sidebar['admins'],
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
        $user = $this->user($request);
        return $this->main($request, view('upload', [
            'token' => $request->session()->get('token'),
            'user' => $user
        ]));
    }

    /**
     * Render adminUploadValidationCode view
     *
     * @return [response] view
     */
    public function adminUploadValidationCode(Request $request)
    {
        $user = $this->user($request);
        return $this->main($request, view('admin/upload-validation-code', [
            'token' => $request->session()->get('token'),
            'user' => $user
        ]));
    }

    /**
     * Render upload view
     *
     * @return [response] view
     */
    public function resetPassword(Request $request, $code)
    {
        if (\Cache::store('redis')->has($code)) {
            return $this->main($request, view('reset_password', [
                'code' => $code
            ]));
        } else {
            return redirect()->route('index');
        }
    }

    /**
     * Render main
     *
     * @return [response] view
     */
    public function main($request, $view)
    {
        $user = $this->user($request);
        return view('main', [
            'url' => $request->root(),
            'uri' => $request->path(),
            'token' => $request->session()->get('token'),
            'user' => $user,
            'change_permission' => $this->changePermission($request),
            'add_tags' => $this->addTags($request),
            'add_description' => $this->addDescription($request),
            'login' => $this->login($request),
            'find_password' => $this->findPassword($request),
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
        if (\Cache::store('redis')->has('header_counter')) {
            $counter = json_decode(\Cache::store('redis')->get('header_counter'), true);
        } else {
            $counter = [
                'imageCount' => app(Image::class)->count(),
                'userCount' => app(User::class)->count(),
            ];
            \Cache::store('redis')->put('header_counter', json_encode($counter), 24*60);
        }

        $user = $this->user($request);
        return view('component/header', [
            'token' => $request->session()->get('token'),
            'user' => $user,
            'url' => $request->root(),
            'uri' => $request->path(),
            'imageCount' => $counter['imageCount'],
            'userCount' => $counter['userCount'],
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
     * Render login
     *
     * @return [response] view
     */
    private function findPassword($request)
    {
        if ($request->session()->get('token') === null) {
            return view('component/find_password', []);
        }
    }

    /**
     * Add tags
     *
     * @return [response] view
     */
    private function addTags($request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_WRITE || $user->permission === User::PERMISSION_ADMIN) {
            return view('component/tags_box', [
                'url' => $request->root(),
                'tags' => $this->getSidebarData()['tags']
            ]);
        }
    }

    /**
     * Add description
     *
     * @return [response] view
     */
    private function addDescription($request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_WRITE || $user->permission === User::PERMISSION_ADMIN) {
            return view('component/description_box', []);
        }
    }

    /**
     * Change permission
     *
     * @return [response] view
     */
    private function changePermission($request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            return view('component/change_permission', []);
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
                'url' => $request->root(),
                'show' => $request->input('show') == 'register'
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

    private function getSidebarData()
    {
        if (\Cache::store('redis')->has('index_sidebar')) {
            $sidebar = json_decode(\Cache::store('redis')->get('index_sidebar'), true);
        } else {
            $sidebar = [
                'authors' => app(User::class)->where(['permission' => User::PERMISSION_WRITE])->get(),
                'admins' => app(User::class)->where(['permission' => User::PERMISSION_ADMIN])->get(),
                'tags' => app(Tag::class)->orderBy('created_at', 'desc')->get()
            ];
            \Cache::store('redis')->put('index_sidebar', json_encode($sidebar), 24*60);
        }
        return $sidebar;
    }
}