<?php

namespace App\Http\Controllers\Admin;

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
        unset($modelData['diabetes']);
        unset($modelData['hipertensao']);
        unset($modelData['infarto']);
        unset($modelData['morte_subita']);
        unset($modelData['cancer']);
        unset($modelData['outro']);

        return $this->save($this->table, $modelData);
    }

    public function checkBusinessLogic($data)
    {
        # code...
    }
    
    public function customUpdate($modelData)
    {
        $data['fumante']             = $modelData['fumante'];
        $data['quantidade_cigarros'] = $modelData['quantidade_cigarros'];
        $data['alcool']              = $modelData['alcool'];
        $data['frequencia_alcool']   = $modelData['frequencia_alcool'];
        $data['atividade_fisica']    = $modelData['atividade_fisica'];
        $data['nome_atividade']      = $modelData['nome_atividade'];
        $data['hipertenso']          = $modelData['hipertenso'];
        $data['diabetico']           = $modelData['diabetico'];
        $data['fator_rh']            = $modelData['fator_rh'];
        $data['alergico']            = $modelData['alergico'];
        $data['nome_alergia']        = $modelData['nome_alergia'];
        $data['cirurgia']            = $modelData['cirurgia'];
        $data['nome_cirurgia']       = $modelData['nome_cirurgia'];
        $data['usa_medicamento']     = $modelData['usa_medicamento'];
        $data['nome_medicamento']    = $modelData['nome_medicamento'];
        $data['preventivo_psa']      = $modelData['preventivo_psa'];
        $data['vacina_dt']           = $modelData['vacina_dt'];
        $data['vacina_hb']           = $modelData['vacina_hb'];
        $data['vacina_fa']           = $modelData['vacina_fa'];
        $data['vacina_influenza']    = $modelData['vacina_influenza'];
        $data['vacina_antirrabica']  = $modelData['vacina_antirrabica'];
        $data['mora_sozinho']        = $modelData['mora_sozinho'];
        $data['problema_familiar']   = $modelData['problema_familiar'];
        $data['id']                  = $modelData['id_historico_pessoal'];

        return $this->update($this->table, $data);
    }
}
