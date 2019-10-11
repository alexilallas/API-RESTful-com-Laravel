<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExameFisicoController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'exame_fisico_geral';

    /**
     * @var PacienteController
     */
    private $paciente;

    public function __construct()
    {
        $this->paciente = new PacienteController();
    }

    /**
     * Customiza os dados e chama método para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        unset($modelData['nome']);
        $modelData['enfermeiro'] = $this->getAutenticatedUser()->name;

        return $this->save($this->table, $modelData);
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
        unset($modelData['nome']);
        unset($modelData['paciente_id']);
        unset($modelData['data_exame']);
        unset($modelData['enfermeiro']);

        $this->update($this->table, $modelData);
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
        $result = DB::table($this->table)->where(['data' => $data['data'], 'paciente_id' => $data['paciente_id']])->count();
        if ($result > 0) {
            $this->cancel('O paciente '.$data['nome'].' já realizou um exame físico nessa data!');
        }
    }

    /**
     * Busca todos os os pacientes e adiciona flag 'hasExameFisico'
     * para indicar se o paciente possui exame físico
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $pacientes = $this->paciente->find()->original['data']['pacientes'];
        $pacientes = $this->hasExameFisico($pacientes);

        return $this->jsonSuccess('Pacientes cadastrados', compact('pacientes'));
    }

    /**
     * Busca os dados de um exame físico pelo ID do paciente
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return json o resultado da busca
     */
    public function findById(Request $req)
    {
        $id = $this->getIdByRequest($req);

        $exameFisico = DB::table($this->table)
        ->where('paciente_id', '=', $id)
        ->select($this->table.'.*')
        ->orderByRaw('data DESC')
        ->get();

        return $this->jsonSuccess('Exame físico do Paciente com id: '.$id, compact('exameFisico'));
    }

    /**
     * Busca os dados de um exame físico pelo ID do paciente e data de evolução
     *
     * @param int $id O ID do paciente
     * @param date $data A data do atendimento
     *
     * @return json o resultado da busca
     */
    public function findByIdAndDate($id, $data)
    {
        $exameFisico = DB::table($this->table)
        ->where('paciente_id', '=', $id)
        ->where('data', '=', $data)
        ->select($this->table.'.*')
        ->orderByRaw('data DESC')
        ->get();

        return $this->jsonSuccess("Exame físico do Paciente com id: {$id} e data: {$data}", compact('exameFisico'));
    }

    /**
     * Adiciona um exame físico de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function postExame()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'Criou um Exame Físico do paciente '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Exame Físico adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    /**
     * Atualiza um exame físico de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function updateExame()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'Editou um Exame Físico do paciente '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Exame físico atualizado com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    /**
     * Verifica se os pacientes possuem exame físico cadastrado para melhor tratamento dos dados
     * na tabela da tela 'Exame Físico'
     *
     * @param array $pacientes os dados pessoais dos pacientes
     *
     * @return array $pacientes O mesmo dado de entrada, e um campo adicional
     * indicando se possui ou não exame físico
     */
    public function hasExameFisico($pacientes)
    {
        $req = new Request();
        foreach ($pacientes as $key => $paciente) {
            $req->request->add(['id' => $paciente->id]);
            if (count($this->findById($req)->original['data']['exameFisico']) > 0) {
                $pacientes[$key]->hasExame = true;
            } else {
                $pacientes[$key]->hasExame = false;
            }
        }

        return $pacientes;
    }
}
