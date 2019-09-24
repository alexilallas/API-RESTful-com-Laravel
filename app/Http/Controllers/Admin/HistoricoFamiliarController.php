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
        $data['diabetes']      = isset($modelData['diabetes'])  ? true : false;
        $data['hipertensao']   = isset($modelData['hipertensao'])  ? true : false;
        $data['infarto']       = isset($modelData['infarto'])  ? true : false;
        $data['morte_subita']  = isset($modelData['morte_subita'])  ? true : false;
        $data['cancer']        = isset($modelData['cancer'])  ? true : false;
        $data['outro']         = isset($modelData['outro']) ? $modelData['outro'] : null;

        return $this->save($this->table, $data);
    }

    public function checkBusinessLogic($data)
    {
        # code...
    }

    public function customUpdate($modelData)
    {
        $data['diabetes']      = $modelData['diabetes'];
        $data['hipertensao']   = $modelData['hipertensao'];
        $data['infarto']       = $modelData['infarto'];
        $data['morte_subita']  = $modelData['morte_subita'];
        $data['cancer']        = $modelData['cancer'];
        $data['outro']         = $modelData['outro'];
        $data['id']            = $modelData['id_historico_familiar'];

        return $this->update($this->table, $data);
    }
}
