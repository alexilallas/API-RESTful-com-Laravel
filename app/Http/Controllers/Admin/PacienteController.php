<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Paciente;
use App\Contato;

class PacienteController extends Controller
{
    private $table = 'pacientes';
    private $contato;
    
    public function __construct(){
        $this->contato = new ContatoController();
    }

    public function find()
    {
        $pacientes = Paciente::all();
        return response()->success(compact('pacientes'));
    }

    public function postPaciente()
    {
        $modelData = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($modelData, 'criarPaciente');
            $idPaciente = DB::getPdo()->lastInsertId();
            $modelData['paciente_id'] = $idPaciente;
            $this->contato->customSave($modelData);
            \DB::commit();
            return $this->jsonSuccess('Paciente adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function customSave($data)
    {
        unset($data['nome_contato']);
        unset($data['numero_contato']);
        unset($data['tipo_paciente']);
        
        return $this->save($this->table, $data);
    }

}
