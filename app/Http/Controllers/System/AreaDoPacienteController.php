<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AreaDoPacienteController extends Controller
{
    private $prontuario;

    public function __construct()
    {
        $this->prontuario = new ProntuarioController();
    }


    public function getProntuario()
    {
        $data = $this->jsonDecode();

        $paciente = DB::table('pacientes')->where('cpf_rg', $data['cpf_rg'])->where('data_nascimento', $data['data_nascimento'])->first();
        
        if (!$paciente) {
            return $this->jsonError('Paciente não encontrado!');
        } else {
            $req = new Request();
            $req->request->add(['id' => $paciente->id]);
            $prontuario = $this->prontuario->findById($req)->original['data']['prontuario'];

            return $this->jsonSuccess('Paciente encontrato!', $prontuario);
        }
    }
}
