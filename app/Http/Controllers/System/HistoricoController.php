<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoricoController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'historicos';

    /**
     * @var HistoricoPessoalController Instância que será utilizada para operações
     */
    private $historicoPessoal;

    /**
     * @var HistoricoFamiliarController Instância que será utilizada para operações
     */
    private $historicoFamiliar;

    /**
     * @var PacienteController Instância que será utilizada para operações
     */
    private $paciente;

    public function __construct()
    {
        $this->historicoPessoal = new HistoricoPessoalController();
        $this->historicoFamiliar = new HistoricoFamiliarController();
        $this->paciente = new PacienteController();
    }

    /**
     * Customiza os dados e chama métodos para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        $historicoData['paciente_id'] = $modelData['paciente_id'];
        $historicoData['historico_familiar_id'] = $this->historicoFamiliar->customSave($modelData);
        $historicoData['historico_pessoal_id'] = $this->historicoPessoal->customSave($modelData);

        return $this->save($this->table, $historicoData);
    }

    /**
     * Customiza os dados e chama métodos para atualizar
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
    public function customUpdate($modelData)
    {
        $this->historicoPessoal->customUpdate($modelData);
        $this->historicoFamiliar->customUpdate($modelData);
    }

    /**
     * Checa a regra de negócio para a uma tabela
     *
     * @param array $data Os dados que serão utilizados para a verificação
     *
     * @return void
     */
    public function checkBusinessLogic($data)
    {
        $result = DB::table($this->table)->where('paciente_id', $data['paciente_id'])->count();
        if ($result > 0) {
            $this->cancel('O paciente '.$data['nome'].' já possui histórico médico!');
        }
    }

    /**
     * Busca todos os pacientes e adiciona flag 'hasHistorico'
     * para indicar se o paciente possui histórico médico
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasHistoricoMedico($pacientes);

        return $this->jsonSuccess('Pacientes cadastrados', compact('pacientes'));
    }


    /**
     * Busca os dados de um histórico pelo ID do paciente
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return json o resultado da busca
     */
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
     * Adiciona o histórico médico de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
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
     * Atualiza o histórico médico de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
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

    /**
     * Verifica se os pacientes possuem histórico médico cadastrado para melhor tratamento dos dados
     * na tabela da tela 'Histórico Médico'
     *
     * @param array $pacientes os dados pessoais dos pacientes
     *
     * @return array $pacientes O mesmo dado de entrada, e um campo adicional
     * indicando se possui ou não histórico médico
     */
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
}
