<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PrescricaoInternaController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'prescricao_interna';

    /**
     * @var InventarioController
     */
    private $inventario;

    public function __construct()
    {
        $this->inventario = new InventarioController();
    }

    /**
     * Customiza os dados e chama método para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        // Salva a prescrição
        foreach ($modelData as $key => $prescricao) {
            $data['evolucao_paciente_id'] = $prescricao['evolucao_paciente_id'];
            $data['medicamento'] = $prescricao['medicamento'];
            $data['quantidade']  = $prescricao['quantidade'];

            $this->save($this->table, $data);
        }

        // Subtrai os medicamentos o inventário
        foreach ($modelData as $key => $prescricao) {

            $this->inventario->decrement($prescricao['nome'], $prescricao['quantidade']);
        }

    }

    /**
     * Customiza os dados e chama métodos para atualizar
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
    public function customUpdate($modelData)
    {
        foreach ($variable as $key => $value) {
            # code...
        }

        $this->update($this->table, $data);
    }
}
