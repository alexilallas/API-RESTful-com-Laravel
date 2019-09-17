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
    /**
     * Rotas para Paciente
     */
    Route::get('paciente', 'PacienteController@find');
    Route::get('paciente/{id}', 'PacienteController@findById');
    Route::post('paciente', 'PacienteController@postPaciente');

    /**
     * Rotas para Anamnese
     */
    Route::get('anamnese', 'AnamneseController@find');
    Route::get('anamnese/{id}', 'AnamneseController@findById');
    Route::post('anamnese', 'AnamneseController@postAnamnese');

});


