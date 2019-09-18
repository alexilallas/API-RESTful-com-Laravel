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
}
