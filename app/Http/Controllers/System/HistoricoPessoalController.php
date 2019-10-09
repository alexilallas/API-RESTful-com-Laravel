<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoPessoalController extends Controller
{
    private $table = 'historico_pessoal';

    public function __construct()
    {
    }

    /**
     * @param Array com dados que serão salvos
     * @return Boolean com resultado da operação
    **/
    public function customSave($modelData)
    {
        unset($modelData['paciente_id']);
        unset($modelData['diabetes']);
        unset($modelData['hipertensao']);
        unset($modelData['infarto']);
        unset($modelData['morte_subita']);
        unset($modelData['cancer']);
        unset($modelData['outro']);
        unset($modelData['nome']);

        return $this->save($this->table, $modelData);
    }

    public function checkBusinessLogic($data)
    {
        # checar se já existe histórico pra aquele paciente
    }

    public function customUpdate($modelData)
    {
        $data['id'] = $modelData['id_historico_pessoal'];
        unset($modelData['diabetes']);
        unset($modelData['hipertensao']);
        unset($modelData['infarto']);
        unset($modelData['morte_subita']);
        unset($modelData['cancer']);
        unset($modelData['outro']);
        unset($modelData['nome']);
        unset($modelData['id_historico_pessoal']);
        unset($modelData['id_historico_familiar']);
        unset($modelData['paciente_id']);
        $data = $modelData;

        return $this->update($this->table, $data);
    }
}
