<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Paciente;
use App\Endereco;

class PacienteController extends Controller
{
    public function getPacientes()
    {
        $pacientes = Paciente::all();

        return response()->success(compact('pacientes'));
    }

    public function postPaciente(Request $req)
    {
        $input = file_get_contents('php://input');
        $jsonDecode = json_decode($input);

        dd($jsonDecode);
    }
}
