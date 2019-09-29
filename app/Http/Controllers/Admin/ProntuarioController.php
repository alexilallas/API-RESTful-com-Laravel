<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProntuarioController extends Controller
{
    private $paciente;
    private $historico;
    private $exameFisico;
    private $evolucao;

    public function __construct()
    {
        $this->paciente = new PacienteController();
        $this->historico = new HistoricoController();
        $this->exameFisico = new ExameFisicoController();
        $this->evolucao = new EvolucaoController();
    }


    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];

        return $this->jsonSuccess('Pacientes com prontuário', compact('pacientes'));
    }

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
