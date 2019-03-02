<?php

$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('register', 'AuthController@register');

    $router->post('login', 'AuthController@login');

    $router->post('find-password', 'AuthController@findPassword');

    $router->post('reset-password/{code}', 'AuthController@resetPassword');

    $router->group(['middleware' => ['auth']], function ($router) {
        $router->put('', 'AuthController@update');

        $router->delete('logout', 'AuthController@logout');

        $router->get('', 'AuthController@view');

        $router->put('usin/{id}', 'AuthController@updateByUsin');
    });

    $router->get('export', 'AuthController@export');
});

$router->group(['prefix' => 'download'], function ($router) {
    $router->group(['middleware' => ['auth']], function ($router) {
        $router->post('{image}', 'DownloadController@view');
    });
    $router->get('action/{id}', 'DownloadController@action');
});

$router->group(['prefix' => 'image'], function ($router) {
    $router->get('view/cache/{id}', 'ImageController@viewImageCache');

    $router->group(['middleware' => ['auth']], function ($router) {
        $router->post('', 'ImageController@upload');

        $router->put('{id}', 'ImageController@update');

        $router->delete('{id}', 'ImageController@delete');
        
        $router->get('', 'ImageController@userView');
    });
    $router->get('visitor', 'ImageController@visitorView');
});

$router->group(['prefix' => 'validation-code'], function ($router) {
    $router->group(['middleware' => ['auth']], function ($router) {
        $router->post('', 'ValidationCodeController@upload');
    });
    $router->get('', 'ValidationCodeController@export');
});

// 视觉

$router->get('', ['as' => 'index', 'uses' => 'ViewController@index']);

$router->get('upload', 'ViewController@upload');

$router->get('reset-password/{id}', 'ViewController@resetPassword');

$router->group(['prefix' => 'admin'], function ($router) {
    $router->get('upload-validation-code', 'ViewController@adminUploadValidationCode');
});