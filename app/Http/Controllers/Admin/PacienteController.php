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
        //captura dados do front-end
        $paciente = $this->jsonDecode();

        //salva dados em cada tabela apropriada
        try {
            //$responsePaciente = $this->customSave($paciente);
            $responseContato = $this->contato->customSave($paciente);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        if($responseContato == true){
            return $this->jsonMessage('Paciente adicionado com sucesso!', 200);
        }
        return response()->json(['message' => 'Falha ao adicionar o paciente!', 'status' => 400], 400);
        
        
    }

    public function customSave($modelData)
    {
     return $this->save($this->tabela, $data);

    }

}
