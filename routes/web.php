<?php

Route::get('/', 'ListController@index')->name('home');
Route::get('/partaker/enrollment_proof/{tramit_id}', 'ListController@enrollmentProof')->name('e_proof');
Route::resource('/assign/{assign_id}/es', 'EsController', ['middleware' => 'auth']);

Route::get('tramite/{id_tramite}/{doc}', 'RpsController@document')->name('get_document');

Route::get('program/{id}/partakers', 'RpsController@partakers')->name('users_list');
Route::get('program/{id}/partakers/estudiantes_programa_excel', 'RpsController@ProgramPartakersExcel')->name('students_list');
Route::resource('program/{program_id}/partakers/{partaker_id}/ecpr', 'EcprController', ['middleware' => 'auth']);
Route::resource('program/{program_id}/partakers/{partaker_id}/{stage}/ecpo', 'EcpoController', ['middleware' => 'auth']);
Route::resource('/program/{program_id}/patient/{patient_id}/fe', 'ProceduresController');

// ws para programas dentro de usuarios
Route::get('get-programs/{supId}', 'UsuarioController@getPrograms');
Route::get('get-patients/{programId}', 'UsuarioController@getPatients');
Route::get('centers', 'UsuarioController@getCenters');
Route::get('cdrneeded/{centerId}', 'UsuarioController@cdrNeeded');
Route::get('programneeded/{centerId}', 'UsuarioController@programNeeded');

Route::resource('/usuario', 'UsuarioController');
// Route::get('/usuario/{patientId}/patientExcel', 'UsuarioController@patientExcel')->name('patientExcel');
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

    Route::get('descargar-archivo/{clave}/{id}/{extension}', 'UsuarioController@bajarDocumento')->name('usuario.bajar');

    Route::post('upCI', 'Fe3cdrController@upCI')->name('upCI');
    Route::get('downCI', 'Fe3cdrController@downCI')->name('downCI');
});

Route::group(['prefix' => 'excel', 'middleware' => 'auth'], function() {
    Route::get('fdg/{patientId}', 'ExcelController@fdg')->name('fdge');
    Route::get('cdr/{patientId}', 'ExcelController@cdr')->name('cdre');
    Route::get('ps/{ps}', 'ExcelController@ps')->name('pse');
    Route::get('re/{id}', 'ExcelController@re')->name('ree');
    Route::get('rs/{id}', 'ExcelController@rs')->name('rse');
    Route::get('he/{id}', 'ExcelController@he')->name('hee');
    Route::get('cssp/{id}', 'ExcelController@cssp')->name('csspe');

    Route::get('patient/{patientId}', 'ExcelController@patientAll')->name('patiente');
});

Route::get('/recepcion/{centerId}', 'UsuarioController@recepcion', ['middleware' => 'auth'])->name('recepcion');

Route::get('/asignar/{center_id}/{fecha?}', 'CalendarController@index')->name('asignar');
Route::get('/getStudents/{date}/{sup_id}', 'CalendarController@getStudents')->name('get_students');
Route::post('/make-appo', 'CalendarController@makeAppo')->name('make_appo');
Route::delete('/cancel_appo/{id}', 'CalendarController@cancelAppo')->name('cancel_appo');
Route::group(['prefix' => '/procedures/3/', 'middleware' => 'auth'], function() {
        Route::get('/1/rps/pdf/{id}', 'RpsController@pdf')->name('rps_pdf');
        Route::get('/1/rps/filter/{stage}/{sup}/{per}', 'RpsController@filter')->name('rps_filter');
        Route::get('/1/rps/excel/{stage}/{sup}/{per}', 'RpsController@rps_excel')->name('rps_excel');
        Route::get('/1/rps/del-row/{type}/{id}', 'RpsController@deleteRow')->name('del_row');
        Route::resource('/1/rps', 'RpsController');

        Route::get('/2/lps/pdf/{id}', 'LpsController@pdf')->name('lps_pdf');

});

Route::get('/pdf/fe3/fdg/{id}', 'DynamicPDFController@fe3fdg')->name('fdg_pdf');

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

Route::resource('/partaker', 'PartakerController', ['middleware' => 'auth']);
Route::get('/partaker/search/{searchTerm}', 'PartakerController@search', ['middleware' => 'auth'])->name('par_search');

Route::post('password/change', 'ListController@changePass')->name('pass_up');

Route::post('/clone_program', 'RpsController@cloneProgram');

Route::post('/program/{program}/partakers/register', 'EnrollController@enrolledBySup'); // no tiene nombre por que es para vue

Route::get('/filtrar_por_etapa/{center_id}/{supervisor_id}/{etapa}/{semestre}', 'UsuarioController@filterByEtapa');
Route::post('asignar_por_etapa', 'UsuarioController@assign');

Auth::routes();

Route::get('configuracion', 'ConfiguracionController@index', ['middleware' => 'auth'])->name('configuracion.index');
Route::post('configuracion', 'ConfiguracionController@update', ['middleware' => 'auth'])->name('configuracion.update');

Route::get('refresh-csrf', function(){
    return csrf_token();
});


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

use App\User;
use App\Partaker;

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

Route::get('/create-missing-users', function() {
    $partakers = Partaker::where('registro_extemporaneo', '>', 20000)->get();
    foreach ($partakers as $partaker) {
        if (!$partaker->user) {
            User::create([
                'type' => 3,
                'email' => $partaker->correo,
                'password' => bcrypt($partaker->num_cuenta)
                ]);
        }
    }
});