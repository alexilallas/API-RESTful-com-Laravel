<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EvolucaoController extends Controller
{
    private $table = 'evolucao_pacientes';

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
        unset($modelData['data_evolucao']);
        return $this->update($this->table, $modelData);
    }

    public function checkBusinessLogic($data)
    {
        $result = DB::table($this->table)->where(['data' => $data['data'],'paciente_id' => $data['paciente_id']])->count();
        if ($result > 0) {
            $this->cancel('Já houve um atendimento registrado nesse dia para o paciente '.$data['nome'].'!');
        }
    }

    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasEvolucao($pacientes);

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

        return $this->jsonSuccess('Evolucões do Paciente com id: '.$id, compact('paciente'));
    }

    public function hasEvolucao($pacientes)
    {
        $req = new Request();
        foreach ($pacientes as $key => $paciente) {
            $req->request->add(['id' => $paciente->id]);
            if (count($this->findById($req)->original['data']['paciente']) > 0) {
                $pacientes[$key]->hasEvolucao = true;
            } else {
                $pacientes[$key]->hasEvolucao = false;
            }
        }

        return $pacientes;
    }

    public function postEvolucao()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'criarEvolucao');
            \DB::commit();
            return $this->jsonSuccess('Evolucao adicionada com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function updateEvolucao()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'editarEvolucao');
            \DB::commit();
            return $this->jsonSuccess('Evolucao atualizada com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }
}
