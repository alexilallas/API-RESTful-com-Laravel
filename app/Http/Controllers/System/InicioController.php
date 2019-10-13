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
        // Para Cards de quantitativo
        $pacientes = count($this->paciente->find()->original['data']['pacientes']);
        $usuarios = count($this->usuario->find()->original['data']['usuarios'])-1; // remove meu usuário de teste da contagem
        $inventario = count($this->inventario->find()->original['data']['itens']);
        $atendimentos = DB::table('exame_fisico_geral')
        ->whereRaw("DATE_FORMAT(data, '%m') = ".date('m'))
        ->whereRaw("DATE_FORMAT(data, '%Y') = ".date('Y'))
        ->count();

        // Para Gráficos, por padrão serão capturados dados do ano corrente
        $GraphicsData = $this->getChartData(date('Y'));
        $atendimentoEnfermagem = $GraphicsData[0];
        $atendimentoConsultas = $GraphicsData[1];
        $frequenciaAtendimentoEnfermagem = $GraphicsData[2];
        $frequenciaAtendimentoConsultas = $GraphicsData[3];

        // Anos que serão mostrados no select options
        $anos = DB::table('exame_fisico_geral')
        ->select(DB::raw('DATE_FORMAT(data, "%Y") as ano'))
        ->orderByRaw('ano DESC')
        ->distinct()
        ->pluck('ano');

        return $this->jsonSuccess('Dados Dashboard', compact([
            'pacientes','usuarios','inventario','atendimentos',
            'atendimentoEnfermagem','atendimentoConsultas',
            'frequenciaAtendimentoEnfermagem', 'frequenciaAtendimentoConsultas','anos'
        ]));
    }

    /**
     * Retorna dados que serão mostrados nos gráficos da Dashboard
     *
     * @param int $ano O ano referência para os dados
     *
     * @return array Os dados dos gráficos em linha e pizza
     */
    public function getChartData($ano)
    {
        // Para Gráfico em pizza de Total de Atendimentos
        $atendimentoEnfermagem = DB::table('exame_fisico_geral')
        ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
        ->count();

        $atendimentoConsultas = DB::table('evolucao_pacientes')
        ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
        ->count();

        // Para Gráfico em linha de Frequencia de Atendimento
        foreach (range(1, 12) as $key => $mes) {
            $frequenciaAtendimentoEnfermagem [$mes-1] = DB::table('exame_fisico_geral')
            ->whereRaw("DATE_FORMAT(data, '%m') = ".$mes)
            ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
            ->count();
            $frequenciaAtendimentoConsultas [$mes-1] = DB::table('evolucao_pacientes')
            ->whereRaw("DATE_FORMAT(data, '%m') = ".$mes)
            ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
            ->count();
        }

        return [
            $atendimentoEnfermagem, $atendimentoConsultas,
            $frequenciaAtendimentoEnfermagem, $frequenciaAtendimentoConsultas
        ];
    }

    /**
     * Retorna os dados para os gráficos da Dashboard com base no ano fornecido
     *
     * @param int $ano O ano referência
     *
     * @return json com o resultado da operação
     */
    public function getChartDatabyYear($ano)
    {
        $GraphicsData = $this->getChartData($ano);
        $atendimentoEnfermagem = $GraphicsData[0];
        $atendimentoConsultas = $GraphicsData[1];
        $frequenciaAtendimentoEnfermagem = $GraphicsData[2];
        $frequenciaAtendimentoConsultas = $GraphicsData[3];

        return $this->jsonSuccess("Dados Gráficos de {$ano}", compact([
            'atendimentoEnfermagem','atendimentoConsultas',
            'frequenciaAtendimentoEnfermagem', 'frequenciaAtendimentoConsultas'
        ]));
    }
}
