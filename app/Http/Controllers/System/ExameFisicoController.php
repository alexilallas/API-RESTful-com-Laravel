<?php

namespace App\Http\Controllers\System;

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
        unset($modelData['nome']);
        return $this->save($this->table, $modelData);
    }

    public function customUpdate($modelData)
    {
        unset($modelData['nome']);
        unset($modelData['paciente_id']);
        unset($modelData['data_exame']);
        return $this->update($this->table, $modelData);
    }

    public function checkBusinessLogic($data)
    {
        $result = DB::table($this->table)->where(['data' => $data['data'], 'paciente_id' => $data['paciente_id']])->count();
        if ($result > 0) {
            $this->cancel('O paciente '.$data['nome'].' já realizou um exame físico nessa data!');
        }
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

        $paciente = DB::table($this->table)
        ->where('paciente_id', '=', $id)
        ->select($this->table.'.*')
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

    public function postExame()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'criarExameFisico');
            \DB::commit();
            return $this->jsonSuccess('Exame Físico adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function updateExame()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'editarExameFisico');
            \DB::commit();
            return $this->jsonSuccess('Exame físico atualizado com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }
}
