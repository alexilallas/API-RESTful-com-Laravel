<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Paciente;
use App\Endereco;
use App\Contato;

class PacienteController extends Controller
{
    private $tabela;
    private $contato;
    private $endereco;
    private $exameFisicoGeral;
    private $evolucaoPaciente;
    private $antecedentesFamiliares;
    private $antecedentesPessoais;

    public function __construct(){
        $this->tabela = 'pacientes';
        $this->contato = new ContatoController();
        $this->endereco = new EnderecoController();
    }

    public function find()
    {
        $pacientes = Paciente::all();
        return response()->success(compact('pacientes'));
    }

    public function postPaciente()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->contato->customSave($data);
            $this->endereco->customSave($data);
            //$this->doSave($paciente, 'CriarPaciente');
            return $this->jsonMessage('Paciente adicionado com sucesso!', 200);
            \BD::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonMessage($th->getMessage(), 400);
        }
    }

    public function customSave($modelData)
    {
        // $data['nome']                       = $modelData['nome'];
        // $data['cpf_rg']                     = $modelData['cpf_rg'];
        // $data['estado_civil']               = $modelData['estado_civil'];
        // $data['naturalidade']               = $modelData['naturalidade'];
        // $data['data_nascimento']            = $modelData['data_nascimento'];
        // $data['sexo']                       = $modelData['sexo'];
        // $data['contato_id']                 = $modelData['contato_id'];
        // $data['endereco_id']                = $modelData['endereco_id'];
        // $data['evolucao_paciente_id']       = $modelData['evolucao_paciente_id'];
        // $data['antecedentes_familiares_id'] = $modelData['antecedentes_familiares_id'];
        // $data['antecedentes_pessoais_id']   = $modelData['antecedentes_pessoais_id'];
        // $data['tipo_paciente_id']           = $modelData['tipo_paciente_id'];
        unsset($modelData['nome_contato']);
        unsset($modelData['numero_contato']);
        $data = $modelData;
        return $this->save($this->tabela, $data);
    }

}
