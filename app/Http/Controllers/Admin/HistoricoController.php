<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\HistoricoPessoal;
use App\HistoricoFamiliar;
use App\Paciente;

class HistoricoController extends Controller
{
    private $historicoPessoal;
    private $historicoFamiliar;
    private $paciente;

    public function __construct()
    {
        $this->historicoPessoal = new HistoricoPessoalController();
        $this->historicoFamiliar = new HistoricoFamiliarController();
        $this->paciente = new PacienteController();
    }


    /**
     * @param Array com todos os dados do histórico médico
     * @return Array com os dados que foram adicionados
    **/
    public function customSave($modelData)
    {
        if ($this->historicoFamiliar->customSave($modelData)) {
            return $this->historicoPessoal->customSave($modelData);
        }

        //return $this->save($this->table, $data);
    }


    public function checkBusinessLogic($data)
    {
        # code...
    }

    
    /**
     * @param Void
     * @return Array com todos os pacientes que possuem histórico médico
    **/
    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasHistoricoMedico($pacientes);

        return $this->jsonSuccess('Pacientes com histórico médico', compact('pacientes'));
    }


    /**
     * @param Request que terá o id do paciente que se deseja pesquisar
     * @return Array com os dados do paciente
    **/
    public function findById(Request $req)
    {
        $id = $req->route('id');
        if (!$id) {
            $id = $req->request->get('id');
        }

        $paciente = DB::table('pacientes')
        ->join('historico_pessoal', 'pacientes.id', '=', 'historico_pessoal.paciente_id')
        ->join('historico_familiar', 'pacientes.id', '=', 'historico_familiar.paciente_id')
        ->where('pacientes.id', '=', $id)
        ->select(
            'pacientes.*',
            'pacientes.id as id_paciente',
            'historico_pessoal.*',
            'historico_pessoal.id as id_historico_pessoal',
            'historico_familiar.*',
            'historico_familiar.id as id_historico_familiar'
        )
        ->get();

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
            $this->doSave($data, 'criarHistoricoMedico');
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
            if (count($this->findById($req)->original['data']['paciente']) > 0) {
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
            $this->doUpdate($data, 'editarHistoricoMedico');
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
