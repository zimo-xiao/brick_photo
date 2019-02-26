<?php

$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('register', 'AuthController@register');

    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => ['auth']], function ($router) {
        $router->put('', 'AuthController@update');

        $router->delete('logout', 'AuthController@logout');

        $router->get('', 'AuthController@view');

        $router->put('usin/{id}', 'AuthController@updateByUsin');
    });
});

$router->group(['prefix' => 'download'], function ($router) {
    $router->group(['middleware' => ['auth']], function ($router) {
        $router->post('{image}', 'DownloadController@view');
    });
    $router->get('action/{id}', 'DownloadController@action');
});

$router->group(['prefix' => 'image'], function ($router) {
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
});

// 视觉

$router->get('', 'ViewController@index');

$router->get('upload', 'ViewController@upload');

$router->group(['prefix' => 'admin'], function ($router) {
    $router->get('upload-validation-code', 'ViewController@adminUploadValidationCode');
});