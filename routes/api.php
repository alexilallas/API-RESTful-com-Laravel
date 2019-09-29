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

Route::namespace('Admin')->group(function () {
    Route::middleware('jwt.auth')->group(function () {
        /**
         * Rotas para Paciente
         */
        Route::get('paciente', 'PacienteController@find');
        Route::get('paciente/{id}', 'PacienteController@findById');
        Route::post('paciente', 'PacienteController@postPaciente');
        Route::put('paciente', 'PacienteController@updatePaciente');

        /**
         * Rotas para Histórico
         */
        Route::get('historico', 'HistoricoController@find');
        Route::get('historico/{id}', 'HistoricoController@findById');
        Route::post('historico', 'HistoricoController@postHistorico');
        Route::put('historico', 'HistoricoController@updateHistorico');

        /**
         * Rotas para Exame
         */
        Route::get('exame', 'ExameFisicoController@find');
        Route::get('exame/{id}', 'ExameFisicoController@findById');
        Route::post('exame', 'ExameFisicoController@postExame');
        Route::put('exame', 'ExameFisicoController@updateExame');

        /**
         * Rotas para Evolução
         */
        Route::get('evolucao', 'EvolucaoController@find');
        Route::get('evolucao/{id}', 'EvolucaoController@findById');
        Route::post('evolucao', 'EvolucaoController@postEvolucao');
        Route::put('evolucao', 'EvolucaoController@updateEvolucao');

        /**
         * Rotas para Prontuário
         */
        Route::get('prontuario', 'ProntuarioController@find');
        Route::get('prontuario/{id}', 'ProntuarioController@findById');
    });
});

Route::namespace('JWT')->group(function () {
    Route::post('login', 'AuthController@login');
});
