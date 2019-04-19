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
Route::group(['prefix' => '/procedures/3/'], function() {
    Route::get('{procedure?}', 'ProceduresController@index')->name('procedures');
    Route::get('{procedure}/{number}', 'ProceduresController@doc')->name('procedure');
    Route::group(['prefix' => 'ie'], function() {
        Route::resource('/1/rps', 'RpsController');
        Route::resource('/2/lps', 'LpsController');
        Route::resource('/3/lps', 'LpsController');
        Route::resource('/4/na', 'Ie4naController');
        Route::resource('/5/na', 'Ie5naController');
    });
    Route::group(['prefix' => 'fe'], function() {
        Route::get('/1/ecpr/pdf/{id}', 'EcprController@pdf')->name('ecpr_pdf');
        Route::resource('/1/ecpr', 'EcprController');

        Route::get('/1/ecpo/pdf/{id}', 'EcpoController@pdf')->name('ecpo_pdf');
        Route::resource('/1/ecpo', 'EcpoController');

        Route::resource('/2/e_d', 'Fe2Controller');

        Route::resource('/3/fdg', 'FE3FDGController'); // TODO homologate urls
        Route::resource('/3/cdr', 'Fe3cdrController');

        Route::get('/4/ps/pdf/{id}', 'PsController@pdf')->name('ps_pdf');
        Route::resource('/4/ps', 'PsController');
        
        Route::get('/5/re/pdf/{id}', 'ReController@pdf')->name('re_pdf');
        Route::resource('/5/re', 'ReController');

        Route::get('/6/rs/pdf/{id}', 'RsController@pdf')->name('rs_pdf');
        Route::resource('/6/rs', 'RsController');

        Route::resource('/7/rs', 'RsController');

        Route::get('/8/he/pdf/{id}', 'HeController@pdf')->name('he_pdf');
        Route::resource('/8/he', 'HeController');

        Route::get('/8/cssp/pdf/{id}', 'CsspController@pdf')->name('cssp_pdf');
        Route::resource('/8/cssp', 'CsspController');
    });
    Route::group(['prefix' => 'ee'], function() {
        Route::resource('/1/es', 'EsController');
        Route::resource('/2/na', 'Ee2naController');
    });

});

// Route::resource('/procedures/3/fe/3/fdg', 'ProceduresController@doc')->name('fdg');
// Route::get('/procedures/gr', 'IeController@index')->name('gr');


// Route::resource('/FE3FDG', 'FE3FDGController');
// Route::resource('/fe3cdr', 'Fe3cdrController');

Route::get('/pdf/fe3/fdg/{id}', 'DynamicPDFController@fe3fdg')->name('fdg');
Route::get('/html/fe3/fdg/{id}', 'DynamicPDFController@fe3fdg_html')->name('fdg_html');
Route::get('/pdf/fe3/cdr/{id}', 'DynamicPDFController@fe3cdr')->name('cdr');
Route::get('/html/fe3/cdr/{id}', 'DynamicPDFController@fe3cdr_html')->name('cdr_html');

Route::post('/asignar', 'ListController@update');

Auth::routes();