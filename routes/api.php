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


Route::middleware('jwt.auth')->group(function () {

    /**
     * Rotas para o gerenciamento de pacientes
     */
    Route::namespace('System')->group(function () {
        /**
         * Rotas para Paciente
         */
        Route::get(
            'paciente',
            [
                'middleware' => 'acl:criarPaciente',
                'uses' => 'PacienteController@find'
            ]
        );
        Route::get(
            'paciente/{id}',
            [
                'middleware' => 'acl:criarPaciente',
                'uses' => 'PacienteController@findById'
            ]
        );
        Route::post(
            'paciente',
            [
                'middleware' => 'acl:criarPaciente',
                'uses' => 'PacienteController@postPaciente'
            ]
        );
        Route::put(
            'paciente',
            [
                'middleware' => 'acl:editarPaciente',
                'uses' => 'PacienteController@updatePaciente'
            ]
        );

        /**
         * Rotas para Histórico
         */
        Route::get(
            'historico',
            [
                'middleware' => 'acl:criarHistoricoMedico',
                'uses' => 'HistoricoController@find'
            ]
        );
        Route::get(
            'historico/{id}',
            [
                'middleware' => 'acl:criarHistoricoMedico',
                'uses' => 'HistoricoController@findById'
            ]
        );
        Route::post(
            'historico',
            [
                'middleware' => 'acl:criarHistoricoMedico',
                'uses' => 'HistoricoController@postHistorico'
            ]
        );
        Route::put(
            'historico',
            [
                'middleware' => 'acl:editarHistoricoMedico',
                'uses' => 'HistoricoController@updateHistorico'
            ]
        );

        /**
         * Rotas para Exame
         */
        Route::get(
            'exame',
            [
                'middleware' => 'acl:criarExameFisico',
                'uses' => 'ExameFisicoController@find'
            ]
        );
        Route::get(
            'exame/{id}',
            [
                'middleware' => 'acl:criarExameFisico',
                'uses' => 'ExameFisicoController@findById'
            ]
        );
        Route::get(
            'exame/{id}/{date}',
            [
                'middleware' => 'acl:criarExameFisico',
                'uses' => 'ExameFisicoController@findByIdAndDate'
            ]
        );
        Route::post(
            'exame',
            [
                'middleware' => 'acl:criarExameFisico',
                'uses' => 'ExameFisicoController@postExame'
            ]
        );
        Route::put(
            'exame',
            [
                'middleware' => 'acl:editarExameFisico',
                'uses' => 'ExameFisicoController@updateExame'
            ]
        );

        /**
         * Rotas para Evolução
         */
        Route::get(
            'evolucao',
            [
                'middleware' => 'acl:criarEvolucao',
                'uses' => 'EvolucaoController@find'
            ]
        );
        Route::get(
            'evolucao/{id}',
            [
                'middleware' => 'acl:criarEvolucao',
                'uses' => 'EvolucaoController@findById'
            ]
        );
        Route::get(
            'evolucao/{id}/{date}',
            [
                'middleware' => 'acl:criarEvolucao',
                'uses' => 'EvolucaoController@findByIdAndDate'
            ]
        );
        Route::post(
            'evolucao',
            [
                'middleware' => 'acl:criarEvolucao',
                'uses' => 'EvolucaoController@postEvolucao'
            ]
        );
        Route::put(
            'evolucao',
            [
                'middleware' => 'acl:editarEvolucao',
                'uses' => 'EvolucaoController@updateEvolucao'
            ]
        );

        /**
         * Rotas para Prontuário
         */
        Route::get(
            'prontuario',
            [
                'middleware' => 'acl:visualizarProntuario',
                'uses' => 'ProntuarioController@find'
            ]
        );
        Route::get(
            'prontuario/{id}',
            [
                'middleware' => 'acl:visualizarProntuario',
                'uses' => 'ProntuarioController@findById'
            ]
        );

        /**
         * Rotas para Inventário
         */
        Route::get(
            'inventario',
            [
                'middleware' => 'acl:criarItem',
                'uses' => 'InventarioController@find'
            ]
        );
        Route::get(
            'inventario/{id}',
            [
                'middleware' => 'acl:criarItem',
                'uses' => 'InventarioController@findById'
            ]
        );
        Route::post(
            'inventario',
            [
                'middleware' => 'acl:criarItem',
                'uses' => 'InventarioController@postItem'
            ]
        );
        Route::put(
            'inventario',
            [
                'middleware' => 'acl:editarItem',
                'uses' => 'InventarioController@updateItem'
            ]
        );

        /**
         * Rotas para Auditoria
         */

        Route::get(
             'auditoria',
             [
                'middleware' => 'acl:visualizarAuditoria',
                'uses' => 'AuditoriaController@find'
            ]
         );
    });

    /**
     * Rotas para o gerenciamento de usuário
     */
    Route::namespace('Manager')->group(function () {

        /**
         * Rotas para Usuários
         */
        Route::get(
            'usuario',
            [
                'middleware' => 'acl:criarUsuario',
                'uses' => 'ManagerController@find'
            ]
        );
        Route::get(
            'usuario/{id}',
            [
                'middleware' => 'acl:criarUsuario',
                'uses' => 'ManagerController@findById'
            ]
        );
        Route::post(
            'usuario',
            [
                'middleware' => 'acl:criarUsuario',
                'uses' => 'ManagerController@postUsuario'
            ]
        );
        Route::put(
            'usuario',
            [
                'middleware' => 'acl:editarUsuario',
                'uses' => 'ManagerController@updateUsuario'
            ]
        );
        Route::put(
            'usuario/reset',
            [
                'middleware' => 'acl:editarUsuario',
                'uses' => 'ManagerController@resetPasswordUsuario'
            ]
        );
    });
});

/**
 * Rotas para autenticação de usuário
 */
Route::namespace('JWT')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
});

/**
 * Rotas para Redefinição de senha
 */
Route::namespace('Auth')->group(function () {
    Route::post('can-reset', 'ResetPasswordController@canResetPassword');
    Route::post('reset', 'ResetPasswordController@resetPassword');
});

