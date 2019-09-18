<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoFamiliarController extends Controller
{
    private $table = "historico_familiar";

    public function __construct()
    {

    }

    /**
     * @param Array com dados que serão salvos
     * @return Boolean com resultado da operação
    **/
    public function customSave($modelData)
    {
        $data['paciente_id']   = $modelData['paciente_id'];
        $data['diabetes']      = $modelData['diabetes'];
        $data['hipertensao']   = $modelData['hipertensao'];
        $data['infarto']       = $modelData['infarto'];
        $data['morte_subita']  = $modelData['morte_subita'];
        $data['cancer']        = $modelData['cancer'];
        $data['outro']         = $modelData['outro'];

        return $this->save($this->table, $data);
    }

    public function checkBusinessLogic($data)
    {
        # code...
    }
}
