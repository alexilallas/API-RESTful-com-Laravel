<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EvolucaoController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'evolucao_pacientes';

    /**
     * @var PacienteController
     */
    private $paciente;

    /**
     * @var PrescricaoInternaController
     */
    private $prescricao;

    public function __construct()
    {
        $this->paciente = new PacienteController();
        $this->prescricao = new PrescricaoInternaController();
    }

    /**
     * Customiza os dados e chama método para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return void
     */
    public function customSave($modelData)
    {
        $data['data'] = $modelData['data'];
        $data['descricao'] = $modelData['descricao'];
        $data['paciente_id'] = $modelData['paciente_id'];
        $data['medico'] = $this->getAutenticatedUser()->name;
        $modelData['evolucao_paciente_id'] = $this->save($this->table, $data);

        $this->prescricao->customSave($modelData);
    }

    /**
     * Customiza os dados e chama método para atualizar
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
    public function customUpdate($modelData)
    {
        $data['data'] = $modelData['data'];
        $data['descricao'] = $modelData['descricao'];
        $data['id'] = $modelData['id'];

        $this->update($this->table, $data);
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
        $result = DB::table($this->table)->where(['data' => $data['data'],'paciente_id' => $data['paciente_id']])->count();
        if ($result > 0) {
            $this->cancel('Já houve um atendimento registrado nesse dia para o paciente '.$data['nome'].'!');
        }
    }

    /**
     * Busca todos os pacientes e adiciona flag 'hasEvolucao'
     * para indicar se o paciente possui evolução cadastrada
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasEvolucao($pacientes);

        return $this->jsonSuccess('Pacientes cadastrados', compact('pacientes'));
    }

    /**
     * Busca os dados de uma evolução pelo ID do paciente
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return json o resultado da busca
     */
    public function findById(Request $req)
    {
        $id = $this->getIdByRequest($req);

        $evolucao = DB::table($this->table)
        ->where('paciente_id', '=', $id)
        ->select($this->table.'.*')
        ->orderByRaw('data DESC')
        ->get();

        $evolucao =  $this->hasPrescricao($evolucao);

        return $this->jsonSuccess('Evolucões do Paciente com id: '.$id, compact('evolucao'));
    }

    /**
     * Busca os dados de uma evolução pelo ID do paciente e data de evolução
     *
     * @param int $id O ID do paciente
     * @param date $data A data do atendimento
     *
     * @return json o resultado da busca
     */
    public function findByIdAndDate($id, $data)
    {
        $evolucao = DB::table($this->table)
        ->where('paciente_id', '=', $id)
        ->where('data', '=', $data)
        ->select($this->table.'.*')
        ->orderByRaw('data DESC')
        ->get();

        $evolucao =  $this->hasPrescricao($evolucao);

        return $this->jsonSuccess("Evolucões do Paciente com id: {$id} e data: {$data}", compact('evolucao'));
    }

    /**
     * Adiciona uma evolução de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
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

    /**
     * Atualiza uma evolução de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
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

    /**
     * Verifica se os pacientes possuem evoluções cadastradas para melhor tratamento dos dados
     * na tabela da tela 'Evolução'
     *
     * @param array $pacientes os dados pessoais dos pacientes
     *
     * @return array $pacientes O mesmo dado de entrada, e um campo adicional
     * indicando se possui evolução
     */
    public function hasEvolucao($pacientes)
    {
        $req = new Request();
        foreach ($pacientes as $key => $paciente) {
            $req->request->add(['id' => $paciente->id]);
            if (count($this->findById($req)->original['data']['evolucao']) > 0) {
                $pacientes[$key]->hasEvolucao = true;
            } else {
                $pacientes[$key]->hasEvolucao = false;
            }
        }

        return $pacientes;
    }

    /**
     * Verifica se os pacientes possuem prescricao interna cadastradas para melhor tratamento dos dados
     * na tabela da tela 'Evolução'
     *
     * @param array $evolucoes os dados pessoais dos pacientes
     *
     * @return array $evolucoes O mesmo dado de entrada, e um campo adicional
     * com a prescricao incluída, se não houver prescricao, o valor será null
     */
    public function hasPrescricao($evolucoes)
    {
        $req = new Request();
        foreach ($evolucoes as $key => $evolucao) {
            $req->request->add(['id' => $evolucao->id]);
            $prescricao = $this->prescricao->findById($req);
            if ($prescricao) {
                $evolucoes[$key]->prescricao = $prescricao;
            } else {
                $evolucoes[$key]->prescricao = null;
            }
        }
        return $evolucoes;
    }
}
