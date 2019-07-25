<?php

// $prefixAdmin = config('zvn.url.prefix_admin');
$prefixAdmin = Config::get('zvn.url.prefix_admin', 'admin123');
$prefixNews = Config::get('zvn.url.prefix_news', 'news123');
Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => $prefixAdmin], function () {

    // ========================== Dashboard ==========================
    $prefix = '';
    $controllerName = 'dashboard';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', [ 'as' => $controllerName, 'uses' => $controller . 'index' ]);
        Route::get('dashboard', [ 'as' => $controllerName . '/dashboard', 'uses' => $controller . 'index' ]);
    });

    // ========================== Slider ==========================
    $prefix = 'slider';
    $controllerName = 'slider';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', [ 'as' => $controllerName, 'uses' => $controller . 'index' ]);
        Route::get('form/{id?}', [ 'as' => $controllerName . '/form', 'uses' => $controller . 'form' ])->where('id', '[0-9]+');
        Route::post('save', ['as' => $controllerName . '/save', 'uses' => $controller . 'save']);
        Route::get('delete/{id}', [ 'as' => $controllerName . '/delete', 'uses' => $controller . 'delete' ])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}', [ 'as' => $controllerName . '/status', 'uses' => $controller . 'status' ])->where('id', '[0-9]+');
    });

    // ========================== Category ==========================
    $prefix = 'category';
    $controllerName = 'category';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', [ 'as' => $controllerName, 'uses' => $controller . 'index' ]);
        Route::get('form/{id?}', [ 'as' => $controllerName . '/form', 'uses' => $controller . 'form' ])->where('id', '[0-9]+');
        Route::post('save', ['as' => $controllerName . '/save', 'uses' => $controller . 'save']);
        Route::get('delete/{id}', [ 'as' => $controllerName . '/delete', 'uses' => $controller . 'delete' ])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}', [ 'as' => $controllerName . '/status', 'uses' => $controller . 'status' ])->where('id', '[0-9]+');
        Route::get('change-is-home-{isHome}/{id}', [ 'as' => $controllerName . '/isHome', 'uses' => $controller . 'isHome' ])->where('id', '[0-9]+');
        Route::get('change-display-{display}/{id}', [ 'as' => $controllerName . '/display', 'uses' => $controller . 'display' ])->where('id', '[0-9]+');
    });
});
Route::group(['prefix' => $prefixNews], function () {
    // ========================== HomaPage ==========================
    $prefix = '';
    $controllerName = 'home';
    Route::group(['prefix' => $prefix], function () use($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', [ 'as' => $controllerName, 'uses' => $controller . 'index' ]);
    });
});

