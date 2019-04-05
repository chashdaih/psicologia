<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ListController@index')->name('home');
Route::get('/apartar', 'CalendarController@index');
Route::get('/estudiantes', 'StudentController@index')->name('students');
Route::resource('/FE3FDG', 'FE3FDGController');
Route::resource('/fe3cdr', 'Fe3cdrController');

Route::get('/pdf/fe3/fdg/{id}', 'DynamicPDFController@fe3fdg')->name('fdg');
Route::get('/html/fe3/fdg/{id}', 'DynamicPDFController@fe3fdg_html')->name('fdg_html');
Route::get('/pdf/fe3/cdr/{id}', 'DynamicPDFController@fe3cdr')->name('cdr');
Route::get('/html/fe3/cdr/{id}', 'DynamicPDFController@fe3cdr_html')->name('cdr_html');

Route::post('/asignar', 'ListController@update');

Auth::routes();