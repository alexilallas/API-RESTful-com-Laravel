<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoPessoalController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'historico_pessoal';

    /**
     * Customiza os dados e chama métodos para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
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

    /**
     * Customiza os dados e chama método para atualizar
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
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
