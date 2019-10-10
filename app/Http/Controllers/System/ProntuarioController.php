<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProntuarioController extends Controller
{
    /**
     * @var PacienteController
     */
    private $paciente;

    /**
     * @var HistoricoPessoalController
     */
    private $historico;

    /**
     * @var ExameFisicoController
     */
    private $exameFisico;

    /**
     * @var EvolucaoController
     */
    private $evolucao;

    public function __construct()
    {
        $this->paciente = new PacienteController();
        $this->historico = new HistoricoController();
        $this->exameFisico = new ExameFisicoController();
        $this->evolucao = new EvolucaoController();
    }

    /**
     * Busca todos os pacientes para mostrar na tela 'Prontuário'
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];

        return $this->jsonSuccess('Pacientes com prontuário', compact('pacientes'));
    }

    /**
     * Busca todos os dados relacionados ao ID do paciente para retornar uma ficha de anamnese
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return json o resultado da busca
     */
    public function findById(Request $req)
    {
        $paciente = $this->paciente->findById($req)->original['data']['paciente'];
        $historico = $this->historico->findById($req)->original['data']['paciente'];
        $exameFisico = $this->exameFisico->findById($req)->original['data']['paciente'];
        $evolucao = $this->evolucao->findById($req)->original['data']['paciente'];

        $prontuario = [
            'paciente' => $paciente,
            'historico' => $historico,
            'exames' => $exameFisico,
            'evolucoes' => $evolucao

        ];

        return $this->jsonSuccess('Prontuário do Paciente', compact('prontuario'));
    }
}
