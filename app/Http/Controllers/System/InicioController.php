<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Manager\UserController;

class InicioController extends Controller
{
    /**
     * @var PacienteController
     */
    private $paciente;

    /**
     * @var UserController
     */
    private $usuario;

    /**
     * @var InventarioController
     */
    private $inventario;

    public function __construct()
    {
        $this->paciente = new PacienteController();
        $this->usuario = new UserController();
        $this->inventario = new InventarioController();
    }

    /**
     * Captura os dados que serão mostrados na Dashboard
     *
     * @param void
     *
     * @return json com o resultado da operação
     */
    public function getDashboardData()
    {
        $pacientes = count($this->paciente->find()->original['data']['pacientes']);
        $usuarios = count($this->usuario->find()->original['data']['usuarios'])-1; // remove meu usuário de teste
        $inventario = count($this->inventario->find()->original['data']['itens']);
        $atendimentos = DB::table('exame_fisico_geral')
        ->whereRaw("DATE_FORMAT(data, '%m') = ".date('m'))
        ->whereRaw("DATE_FORMAT(data, '%Y') = ".date('Y'))
        ->count();

        return $this->jsonSuccess('Dados Dashboard', compact(['pacientes','usuarios','inventario','atendimentos']));
    }

    public function getGraphicAtendimento()
    {

    }
}
