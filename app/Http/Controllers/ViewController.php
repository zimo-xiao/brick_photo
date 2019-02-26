<?php

namespace App\Http\Controllers;

use App\Services\Errors;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;

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

        $user = $this->user($request);
        
        return $this->main($request, view('index', [
            'token' => $request->session()->get('token'),
            'user' => $user,
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
        $user = $this->user($request);
        return view('component/header', [
            'token' => $request->session()->get('token'),
            'user' => $user,
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
                'tags' => app(Tag::class)->all()
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