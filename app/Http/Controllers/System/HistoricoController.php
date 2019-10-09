<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoricoController extends Controller
{
    private $table = 'historicos';
    private $historicoPessoal;
    private $historicoFamiliar;
    private $paciente;

    public function __construct()
    {
        $this->historicoPessoal = new HistoricoPessoalController();
        $this->historicoFamiliar = new HistoricoFamiliarController();
        $this->paciente = new PacienteController();
    }

    public function checkBusinessLogic($data)
    {
        $this->historicoPessoal->checkBusinessLogic($data);
        $this->historicoFamiliar->checkBusinessLogic($data);
    }

    /**
     * @param Array com todos os dados do histórico médico
     * @return void
    **/
    public function customSave($modelData)
    {
        $historicoData['paciente_id'] = $modelData['paciente_id'];
        $historicoData['historico_familiar_id'] = $this->historicoFamiliar->customSave($modelData);
        $historicoData['historico_pessoal_id'] = $this->historicoPessoal->customSave($modelData);

        return $this->save($this->table, $historicoData);
    }


    /**
     * @param Void
     * @return Array com todos os pacientes que possuem histórico médico
    **/
    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasHistoricoMedico($pacientes);

        return $this->jsonSuccess('Pacientes cadastrados', compact('pacientes'));
    }


    /**
     * @param Request que terá o id do paciente que se deseja pesquisar
     * @return Array com os dados do paciente
    **/
    public function findById(Request $req)
    {
        $id = $this->getIdByRequest($req);

        $paciente = DB::table($this->table)
        ->join('historico_pessoal', 'historicos.historico_pessoal_id', '=', 'historico_pessoal.id')
        ->join('historico_familiar', 'historicos.historico_familiar_id', '=', 'historico_familiar.id')
        ->join('pacientes', 'historicos.paciente_id', '=', 'pacientes.id')
        ->where('pacientes.id', '=', $id)
        ->select(
            'historico_pessoal.*',
            'historico_pessoal.id as id_historico_pessoal',
            'historico_familiar.*',
            'historico_familiar.id as id_historico_familiar'
        )
        ->first();

        return $this->jsonSuccess('Histórico do Paciente com id: '.$id, compact('paciente'));
    }


    /**
     * @param Json com os dados que serão salvos
     * @return Json com mensagem de sucesso ou falha
    **/
    public function postHistorico()
    {
        $data = $this->jsonDecode();
        try {
            \DB::beginTransaction();
            $this->doSave($data, 'Criou o Histórido médico do paciente '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Histórico médico adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }


    /**
     * @param Object com dados de todos os pacientes da tabela Pacientes
     * @return Object com uma chave adicional indicando se tem histórico médico ou não
    **/
    public function hasHistoricoMedico($pacientes)
    {
        $req = new Request();
        foreach ($pacientes as $key => $paciente) {
            $req->request->add(['id' => $paciente->id]);
            if ($this->findById($req)->original['data']['paciente']) {
                $pacientes[$key]->hasHistorico = true;
            } else {
                $pacientes[$key]->hasHistorico = false;
            }
        }

        return $pacientes;
    }


    public function updateHistorico()
    {
        $data = $this->jsonDecode();
        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'Editou o Histórico Médico do paciente '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Histórico médico atualizado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }


    public function customUpdate($modelData)
    {
        $this->historicoPessoal->customUpdate($modelData);
        $this->historicoFamiliar->customUpdate($modelData);
    }
}
