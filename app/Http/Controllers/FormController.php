<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function getBasefields(){

        $baseFields = [];

        $sexo = ['Masculino', 'Feminino'];
        $estado_civil = ['Solteiro(a)', 'Casado(a)', 'Viúvo(a)'];
        $tipo_de_paciente = ['Aluno', 'Funcionário','Outro'];

        $baseFields = [
            'sexo' => $sexo,
            'estado_civil' => $estado_civil,
            'tipo_de_paciente' => $tipo_de_paciente
        ];

        return response()->success(compact('estado_civil'));
    }
}
