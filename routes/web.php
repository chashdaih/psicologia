<?php

Route::get('/', 'ListController@index')->name('home');
Route::get('/partaker/enrollment_proof/{tramit_id}', 'ListController@enrollmentProof')->name('e_proof');
Route::resource('/assign/{assign_id}/es', 'EsController', ['middleware' => 'auth']);
// Route::get('partaker/register', 'ListController@partakerRegisterForm')->name('partaker_form');

Route::get('tramite/{id_tramite}/{doc}', 'RpsController@document')->name('get_document');

// Route::resource('/program/{program_id}/patient', 'FE3FDGController');
Route::get('program/{id}/partakers', 'RpsController@partakers')->name('users_list');
Route::resource('program/{program_id}/partakers/{partaker_id}/ecpr', 'EcprController', ['middleware' => 'auth']);
Route::resource('/program/{program_id}/patient/{patient_id}/fe', 'ProceduresController');

// ws para programas dentro de usuarios
Route::get('get-programs/{supId}', 'UsuarioController@getPrograms');
Route::get('get-patients/{programId}', 'UsuarioController@getPatients');
Route::get('centers', 'UsuarioController@getCenters');
Route::get('cdrneeded/{centerId}', 'UsuarioController@cdrNeeded');
Route::get('programneeded/{centerId}', 'UsuarioController@programNeeded');

Route::resource('/usuario', 'UsuarioController');
Route::get('/usuario/{patientId}/patientExcel', 'UsuarioController@patientExcel')->name('patientExcel');
Route::get('/usuario/search/{searchTerm}', 'UsuarioController@search');
Route::get('excel/programs', 'UsuarioController@programsExcel')->name('programs_excel');
Route::group(['prefix' => 'usuario/{patient_id}', 'middleware' => 'auth'], function() {
    Route::resource('fdg', 'FE3FDGController');
    Route::resource('cdr', 'Fe3cdrController');
    Route::resource('ps', 'PsController');
    Route::resource('re', 'ReController');
    Route::resource('breve', 'RsController');
    Route::resource('intervencion', 'RsController');
    Route::resource('he', 'HeController');
    Route::resource('cssp', 'CsspController');

    // Route::post('subir-documento', 'UsuarioController@subirDocumento')->name('usuario.subir');
    Route::get('descargar-archivo/{clave}/{id}/{extension}', 'UsuarioController@bajarDocumento')->name('usuario.bajar');
});

Route::get('/asignar/{center_id}/{fecha?}', 'CalendarController@index')->name('asignar');
Route::get('/getStudents/{date}/{sup_id}', 'CalendarController@getStudents')->name('get_students');
Route::post('/make-appo', 'CalendarController@makeAppo')->name('make_appo');
Route::delete('/cancel_appo/{id}', 'CalendarController@cancelAppo')->name('cancel_appo');
Route::group(['prefix' => '/procedures/3/', 'middleware' => 'auth'], function() {
    // Route::get('{procedure?}', 'ProceduresController@index')->name('procedures');
    // Route::get('{procedure}/{number}', 'ProceduresController@doc')->name('procedure');
    // Route::group(['prefix' => 'ie'], function() {
        Route::get('/1/rps/pdf/{id}', 'RpsController@pdf')->name('rps_pdf');
        Route::get('/1/rps/filter/{stage}/{sup}/{per}', 'RpsController@filter')->name('rps_filter');
        Route::get('/1/rps/excel/{stage}/{sup}/{per}', 'RpsController@rps_excel')->name('rps_excel');
        Route::get('/1/rps/del-row/{type}/{id}', 'RpsController@deleteRow')->name('del_row');
        // Route::get('1/rps/{id}/partakers', 'RpsController@partakers')->name('users_list');
        Route::resource('/1/rps', 'RpsController');


        Route::get('/2/lps/pdf/{id}', 'LpsController@pdf')->name('lps_pdf');
    //     Route::resource('/2/lps', 'LpsController');
    //     Route::resource('/3/lpse', 'LpsController');
    //     Route::get('/4/cr_ss/download/{uri}', 'Ie4naController@download')->name('cr_ss_download');
    //     Route::resource('/4/cr_ss', 'Ie4naController');
    //     Route::resource('/5/o_ep', 'Ie5naController');
    // });
    // Route::group(['prefix' => 'fe'], function() {
    //     Route::get('/1/ecpr/pdf/{id}', 'EcprController@pdf')->name('ecpr_pdf');
    //     Route::resource('/1/ecpr', 'EcprController');

    //     Route::get('/1/ecpo/pdf/{id}', 'EcpoController@pdf')->name('ecpo_pdf');
    //     Route::resource('/1/ecpo', 'EcpoController');

    //     Route::get('/2/e_d/download/{file_name}', 'Fe2Controller@download')->name('e_d_download');
    //     Route::resource('/2/e_d', 'Fe2Controller');

    //     // Route::resource('/3/fdg', 'FE3FDGController'); // TODO homologate urls
    //     Route::resource('/3/cdr', 'Fe3cdrController');

    //     Route::get('/4/ps/pdf/{id}', 'PsController@pdf')->name('ps_pdf');
    //     Route::resource('/4/ps', 'PsController');
        
    //     Route::get('/5/re/pdf/{id}', 'ReController@pdf')->name('re_pdf');
    //     Route::resource('/5/re', 'ReController');

    //     Route::get('/6/rs/pdf/{id}', 'RsController@pdf')->name('rs_pdf');
    //     Route::resource('/6/rs', 'RsController');

    //     Route::resource('/7/rs', 'RsController');

    //     Route::get('/8/he/pdf/{id}', 'HeController@pdf')->name('he_pdf');
    //     Route::resource('/8/he', 'HeController');

    //     Route::get('/8/cssp/pdf/{id}', 'CsspController@pdf')->name('cssp_pdf');
    //     Route::resource('/8/cssp', 'CsspController');
    // });
    // Route::group(['prefix' => 'ee'], function() {
    //     Route::get('/1/es/pdf/{id}', 'EsController@pdf')->name('es_pdf');
    //     Route::resource('/1/es', 'EsController');
    //     Route::get('/2/na/download/{file_name}', 'Ee2naController@download')->name('na_download');
    //     Route::resource('/2/na', 'Ee2naController');
    // });

});

// Route::resource('/procedures/3/fe/3/fdg', 'ProceduresController@doc')->name('fdg');
// Route::get('/procedures/gr', 'IeController@index')->name('gr');


// Route::resource('/FE3FDG', 'FE3FDGController');

Route::get('/pdf/fe3/fdg/{id}', 'DynamicPDFController@fe3fdg')->name('fdg_pdf');
// Route::get('/html/fe3/fdg/{id}', 'DynamicPDFController@fe3fdg_html')->name('fdg_html');
// Route::get('/pdf/fe3/cdr/{id}', 'DynamicPDFController@fe3cdr')->name('cdr');
// Route::get('/html/fe3/cdr/{id}', 'DynamicPDFController@fe3cdr_html')->name('cdr_html');

Route::post('/asignar', 'ListController@update');

Route::get('/inscribirse', 'EnrollController@index')->name('insc');
Route::get('/inscribirse/{id}', 'EnrollController@detail')->name('insc.det');
Route::post('/inscribirse/{id}', 'EnrollController@enroll')->name('insc.enroll');
Route::post('/save_enroll_docs', 'EnrollController@docs')->name('insc.docs');
Route::get('/generateLetter/{program_id}', 'EnrollController@cartaCompromiso')->name('insc.carta');
Route::delete('/disenroll/{enr}', 'EnrollController@disenroll')->name('insc.disenroll');

Route::resource('/evaluar', 'EvaluateStudentController');

Route::resource('/supervisor', 'SupervisorController', ['middleware' => 'auth']);
Route::post('/supervisor/{userId}/changePass', 'SupervisorController@changePassword', ['middleware' => 'auth']);
// Route::get('/supervisor/filter/{id}', 'SupervisorController@filter', ['middleware' => 'auth'])->name('sup_filter');

Route::resource('/partaker', 'PartakerController', ['middleware' => 'auth']);
Route::get('/partaker/search/{searchTerm}', 'PartakerController@search', ['middleware' => 'auth'])->name('par_search');

Route::post('password/change', 'ListController@changePass')->name('pass_up');

Route::post('/clone_program', 'RpsController@cloneProgram');

Route::post('/program/{program}/partakers/register', 'EnrollController@enrolledBySup'); // no tiene nombre por que es para vue

Route::get('/filtrar_por_etapa/{center_id}/{supervisor_id}/{etapa}', 'UsuarioController@filterByEtapa');
Route::post('asignar_por_etapa', 'UsuarioController@assign');

Auth::routes();

Route::get('refresh-csrf', function(){
    return csrf_token();
});

// Route::resource('/cub_type', 'CubTypeController');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

// use App\User;
// use App\Partaker;

// Route::get('/update_users', function() {
//     $users = User::where('type', 3)->get();
//     foreach ($users as $key => $user) {
//         if (strpos($user->email, '@') === false) {
//             $partaker = Partaker::where('num_cuenta', (int)$user->email)->first();
//             if ($partaker && $partaker->correo != null) {
//                 $input = array('email' => $partaker->correo);
//                 $rules = array('email' => 'required|unique:users');
//                 $validator = Validator::make($input, $rules);

//                 if ($validator->passes()) {
//                     $user->email = $partaker->correo;
//                     $user->save();
//                 }

//             }
//         }
//     }
//     dd($users);
// });