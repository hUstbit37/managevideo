<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', 'VueController@index')->where('any', '.*');

//---------------------------------------
// Route::get('/', function () {
//     return view('welcome');
// });
//-------------------------------------

//.....................................
Route::group(['prefix' => '/LearnVuejs'], function () {
    Route::get('/vue.instance', function () {
        return view('LearnVuejs/VueInstance');
    });
    Route::get('/test', function () {
        return view('LearnVuejs/test');
    });
});
//---------------------------------------
Route::get('testsearch.home', 'TestSearchController@home');
Route::get('testsearch.show', 'TestSearchController@show');
Route::post('testsearch.kq', 'TestSearchController@search');
//----------------------------------------