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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Admin')->group(function () {
    Route::get('paciente', 'PacienteController@find');
    Route::post('paciente', 'PacienteController@postPaciente');

    Route::get('anamnese', 'AnamneseController@find');

    Route::get('form', 'FormController@getBasefields');
});


