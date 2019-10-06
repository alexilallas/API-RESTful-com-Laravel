<?php

namespace App\Http\Controllers\System;

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
        $data['data'] = $modelData['data'];
        $data['descricao'] = $modelData['descricao'];
        $data['paciente_id'] = $modelData['paciente_id'];

        return $this->save($this->table, $data);
    }

    public function customUpdate($modelData)
    {
        $data['data'] = $modelData['data'];
        $data['descricao'] = $modelData['descricao'];
        $data['id'] = $modelData['id'];

        return $this->update($this->table, $data);
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
        ->orderByRaw('data DESC')
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
            $this->doSave($data, 'Adicionou uma Evolução ao paciente '.$data['nome']);
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
            $this->doUpdate($data, 'Editou uma Evolução do paciente '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Evolucao atualizada com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }
}
