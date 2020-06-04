<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//---------------------------------------
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::get('getVideo2', 'VueController@getVideo2');
Route::post('upload', 'VueController@upload');

Route::post('show.video', 'VueController@listVideo');
Route::post('loadMoreVideo', 'VueController@loadMoreVideo');
Route::post('add.comment/{id}', 'VueController@addCmt');
Route::post('cmtPaganation/{id}', 'VueController@commentPaganationVue');