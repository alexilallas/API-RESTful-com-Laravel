<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HistoricoPessoal;
use App\HistoricoFamiliar;
use Illuminate\Support\Facades\DB;

class AnamneseController extends Controller
{
    private $historicoPessoal;
    private $historicoFamiliar;

    public function __contruct()
    {
        $this->historicoPessoal = new HistoricoPessoal();
        $this->historicoFamiliar = new HistoricoFamiliar();
    }

    public function customSave($data)
    {
        # code...
    }

    public function checkBusinessLogic($data)
    {
        # code...
    }

    public function find()
    {
        $pacientes = DB::table('pacientes')
        ->join('historico_pessoal', 'pacientes.id','=','historico_pessoal.paciente_id','left')
        ->select('pacientes.*')
        ->get();

        return $this->jsonSuccess('Pacientes aguardando atendimento', compact('pacientes'));
    }
}
