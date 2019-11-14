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

Route::get('/patients/{centerId}/reception', 'ApiController@reception');
Route::post('/patients/{centerId}/update', 'ApiController@receive');

Route::get('/supervisors', 'ApiController@supervisors');