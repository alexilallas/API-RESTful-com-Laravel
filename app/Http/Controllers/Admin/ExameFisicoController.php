<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExameFisicoController extends Controller
{
    private $table = 'exame_fisico_geral';

    private $paciente;

    public function __construct()
    {
        $this->paciente = new PacienteController();
    }

    public function customSave($modelData)
    {
        #code
    }

    public function customUpdate($modelData)
    {
        #code
    }

    public function checkBusinessLogic($data)
    {
        #code
    }

    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasExameFisico($pacientes);

        return $this->jsonSuccess('Pacientes cadastrados', compact('pacientes'));
    }

    public function findById(Request $req)
    {
        $id = $req->route('id');
        if (!$id) {
            $id = $req->request->get('id');
        }

        $paciente = DB::table('pacientes')
        ->join('exame_fisico_geral', 'pacientes.id', '=', 'exame_fisico_geral.paciente_id')
        ->where('pacientes.id', '=', $id)
        ->select(
            'pacientes.*',
            'pacientes.id as id_paciente',
            'exame_fisico_geral.*',
            'exame_fisico_geral.id as id_exame'
        )
        ->get();

        return $this->jsonSuccess('Exame físico do Paciente com id: '.$id, compact('paciente'));
    }

    public function hasExameFisico($pacientes)
    {
        $req = new Request();
        foreach ($pacientes as $key => $paciente) {
            $req->request->add(['id' => $paciente->id]);
            if (count($this->findById($req)->original['data']['paciente']) > 0) {
                $pacientes[$key]->hasExame = true;
            } else {
                $pacientes[$key]->hasExame = false;
            }
        }

        return $pacientes;
    }
}
