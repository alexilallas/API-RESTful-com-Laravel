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
    private $table = 'prescricao_internas';

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
        $data['evolucao_paciente_id'] = $modelData['evolucao_paciente_id'];
        foreach ($modelData['prescricao'] as $key => $prescricao) {
            $data['medicamento'] = $prescricao['nome'];
            $data['quantidade']  = $prescricao['quantidade'];

            $this->save($this->table, $data);
        }

        // Subtrai os medicamentos o inventário
        foreach ($modelData['prescricao'] as $key => $prescricao) {
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

    /**
     * Busca os dados de uma prescricao pelo ID do paciente
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return App\Models\PrescricaoInterna
     */
    public function findById(Request $req)
    {
        $id = $this->getIdByRequest($req);

        return DB::table($this->table)
        ->where('paciente_id', '=', $id)
        ->join('evolucao_pacientes', $this->table.'.evolucao_paciente_id','=', 'evolucao_pacientes.id')
        ->select($this->table.'.*')
        ->orderByRaw('medicamento ASC')
        ->get();
    }
}
