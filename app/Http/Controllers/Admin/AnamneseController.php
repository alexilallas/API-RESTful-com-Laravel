<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\HistoricoPessoal;
use App\HistoricoFamiliar;
use App\Paciente;

class AnamneseController extends Controller
{
    private $historicoPessoal;
    private $historicoFamiliar;
    private $paciente;

    public function __construct()
    {
        // $this->historicoPessoal = new HistoricoPessoalController();
        // $this->historicoFamiliar = new HistoricoFamiliarController();
        $this->paciente = new PacienteController();
    }

    public function customSave($data)
    {
        # code...
    }

    public function checkBusinessLogic($data)
    {
        # code...
    }

    /**
     * @param Void
     * @return Array com todos os pacientes que possuem ficha de anamnese
    **/
    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasFichaAnamnese($pacientes);
        
        return $this->jsonSuccess('Pacientes com ficha de Anamnese', compact('pacientes'));
    }

    /**
     * @param Request que terá o id do paciente que se deseja pesquisar
     * @return Array com os dados do paciente
    **/
    public function findById(Request $req)
    {
        $id = $req->route('id');
        $paciente = DB::table('pacientes')
        ->join('historico_pessoal', 'pacientes.id','=','historico_pessoal.paciente_id','inner')
        ->join('historico_familiar', 'pacientes.id','=','historico_familiar.paciente_id','inner')
        ->where('pacientes.id','=', $id)
        ->select('pacientes.*','historico_pessoal.*','historico_familiar.*')
        ->get();

        return $this->jsonSuccess('Ficha do Paciente com id: '.$id, compact('paciente'));
    }
    

    /**
     * @param Json com os dados que serão salvos
     * @return Json com mensagem de sucesso ou falha
     */
    public function postAnamnese()
    {
        $data = $this->jsonDecode();
        dd($data);

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'criarFichaAnamnese');
            $idPaciente = DB::getPdo()->lastInsertId();
            $data['paciente_id'] = $idPaciente;
            $this->contato->customSave($data);
            \DB::commit();
            return $this->jsonSuccess('Paciente adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    /**
     * @param Object com dados de todos os pacientes da tabela Pacientes
     * @return Object com uma chave adicional indicando se tem ficha de Anamnese ou não
     */
    public function hasFichaAnamnese($pacientes)
    {
        $req = new Request();
        foreach ($pacientes as $key => $paciente) 
        {
            $req->input('id',$paciente->id);
            if(count($this->findById($req)->original['data']['paciente']) > 0)
            {
                $pacientes[$key]->hasAnamnese = true;
            }else
            {
                $pacientes[$key]->hasAnamnese = false;
            }
        }

        return $pacientes;
    }
}
