<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::post('register', 'RegisterController');
        Route::post('login', 'LoginController');
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('groups', 'GroupController@index');
        Route::post('groups/{id}/join', 'GroupController@join');

        Route::middleware('group-member')->group(function () {
            Route::get('notes', 'NoteController@index');
            Route::get('notes/{id}', 'NoteController@show');
            Route::post('notes', 'NoteController@store');
        });
    });
});
