<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoFamiliarController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = "historico_familiar";

    /**
     * Customiza os dados e chama métodos para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        $data['diabetes']      = isset($modelData['diabetes'])  ? true : false;
        $data['hipertensao']   = isset($modelData['hipertensao'])  ? true : false;
        $data['infarto']       = isset($modelData['infarto'])  ? true : false;
        $data['morte_subita']  = isset($modelData['morte_subita'])  ? true : false;
        $data['cancer']        = isset($modelData['cancer'])  ? true : false;
        $data['outro']         = isset($modelData['outro']) ? $modelData['outro'] : null;

        return $this->save($this->table, $data);
    }

    /**
     * Customiza os dados e chama método para atualizar
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
    public function customUpdate($modelData)
    {
        $data['diabetes']      = $modelData['diabetes'];
        $data['hipertensao']   = $modelData['hipertensao'];
        $data['infarto']       = $modelData['infarto'];
        $data['morte_subita']  = $modelData['morte_subita'];
        $data['cancer']        = $modelData['cancer'];
        $data['outro']         = $modelData['outro'];
        $data['id']            = $modelData['id_historico_familiar'];

        $this->update($this->table, $data);
    }

}
