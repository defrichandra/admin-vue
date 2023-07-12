<?php

use App\Http\Controllers\AuthController;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('user', 'AuthController@user');
    Route::post('logout', 'AuthController@logout');
});

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'post'
], function ($router) {
    Route::post('upload', 'PostsController@uploadFile');
    Route::get('/files/{filename}', 'PostsController@getFilePath');
    Route::post('save_post', 'PostsController@save_post');
    Route::get('view_post', 'PostsController@view_post');
    Route::put('update_post/{id}', 'PostsController@update_post');
    Route::delete('delete_post/{id}', 'PostsController@delete_post');
});