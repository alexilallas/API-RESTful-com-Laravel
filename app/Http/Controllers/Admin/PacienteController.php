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
        $pacientes = Paciente::all();
        return $this->jsonSuccess('Pacientes cadastrados', compact('pacientes'));
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

    public function customSave($data)
    {
        unset($data['nome_contato']);
        unset($data['numero_contato']);
        unset($data['tipo_paciente']);

        return $this->save($this->table, $data);
    }

}
