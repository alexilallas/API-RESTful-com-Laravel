<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'pacientes';

    /**
     * @var ContatoController Instância que será utilizada para operações
     */
    private $contato;

    public function __construct()
    {
        $this->contato = new ContatoController();
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
        $contatoData['nome_contato'] = $modelData['nome_contato'];
        $contatoData['numero_contato'] = $modelData['numero_contato'];
        unset($modelData['nome_contato']);
        unset($modelData['numero_contato']);
        $data = $modelData;

        $contatoData['paciente_id'] = $this->save($this->table, $data);
        $this->contato->customSave($contatoData);
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
        $data = $modelData;
        unset($data['nome_contato']);
        unset($data['numero_contato']);
        unset($data['tipo_paciente']);
        unset($data['id_contato']);

        $this->update($this->table, $data);
        $this->contato->customUpdate($modelData);
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
        $result = DB::table($this->table)->where('cpf_rg', $data['cpf_rg'])->count();
        if ($result > 0) {
            $this->cancel('Já existem um paciente cadastrado com o CPF/RG: '.$data['cpf_rg']);
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
        $pacientes = DB::table($this->table)->get();

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
        ->join('contatos', 'contatos.paciente_id', '=', 'pacientes.id')
        ->where($this->table.'.id', $id)
        ->select('pacientes.*', 'contatos.nome as nome_contato', 'contatos.numero as numero_contato', 'contatos.id as id_contato')
        ->first();

        return $this->jsonSuccess('Pacientes cadastrados', compact('paciente'));
    }

    /**
     * Adiciona o histórico médico de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function postPaciente()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'Cadastrou o Paciente '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Paciente adicionado com sucesso!');
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
    public function updatePaciente()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'Editou dados pessoais do paciente '. $data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Paciente atualizado com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }
}
