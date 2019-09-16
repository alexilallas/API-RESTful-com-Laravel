<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    public function getBasefields(){

        $baseFields = [];

        $sexo = ['Masculino', 'Feminino'];
        $estado_civil = ['Solteiro(a)', 'Casado(a)', 'Viúvo(a)'];
        $tipo_de_paciente = ['Aluno', 'Funcionário','Outro'];

        $result = [
            'sexo' => $sexo,
            'estado_civil' => $estado_civil,
            'tipo_paciente' => $tipo_de_paciente
        ];

        //return response()->success(compact('result'));
        return response()->json($result);
    }

    public function checkBusinessLogic($data){
        # code...
    }

    public function customSave($modelData)
    {
        # code...
    }
}
