<?php

use Illuminate\Http\Request;

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

Route::namespace('Api')->group(function () {
    Route::get('/documents', 'DocumentController@index');
    Route::get('/documents/{document}', 'DocumentController@show');
    Route::put('/documents/{document}', 'DocumentController@update');
    Route::delete('/documents/{document}', 'DocumentController@destroy');
    Route::post('/documents', 'DocumentController@store');
});
