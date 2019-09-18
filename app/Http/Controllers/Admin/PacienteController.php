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

    public function __construct()
    {
        $this->contato = new ContatoController();
    }


    public function customSave($modelData)
    {
        unset($modelData['nome_contato']);
        unset($modelData['numero_contato']);
        unset($modelData['tipo_paciente']);
        $data = $modelData;

        return $this->save($this->table, $data);
    }


    public function checkBusinessLogic($data)
    {
        $result = DB::table($this->table)->where('cpf_rg', $data['cpf_rg'])->count();
        if($result > 0)
        {
            $this->cancel('Este paciente já está cadastrado!');
        }
    }

    public function find()
    {
        $pacientes = DB::table($this->table)->get();

        return $this->jsonSuccess('Pacientes cadastrados', compact('pacientes'));
    }

    public function findById(Request $req)
    {
        $id = $req->route('id');
        $paciente = DB::table($this->table)
        ->join('contatos', 'contatos.paciente_id','=','pacientes.id')
        ->where('pacientes.id', $id)
        ->select('pacientes.*','contatos.nome as nome_contato', 'contatos.numero as numero_contato')
        ->get();

        return $this->jsonSuccess('Pacientes cadastrados', compact('paciente'));
    }

    public function postPaciente()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'criarPaciente');
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


}
