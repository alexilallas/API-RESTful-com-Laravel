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

    public function __construct(){
        $this->tabela = 'pacientes';
        $this->contato = new ContatoController();
    }

    public function getPacientes()
    {
        $pacientes = Paciente::all();

        return response()->success(compact('pacientes'));
    }

    public function postPaciente()
    {
        $paciente = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            //$this->customSave($paciente);
            $this->doSave($paciente);
            //$this->contato->customSave($paciente);
            return $this->jsonMessage('Paciente adicionado com sucesso!', 200);
            \BD::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonMessage($th->getMessage(), 400);
        }
    }

    public function customSave($modelData)
    {
     return $this->save($this->tabela, $data);

    }

}
