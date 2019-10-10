<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContatoController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'contatos';

    /**
     * Customiza os dados e chama método para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        if (isset($modelData['nome_contato']) && isset($modelData['numero_contato'])) {
            $data['nome'] = $modelData['nome_contato'];
            $data['numero'] = $modelData['numero_contato'];
            $data['paciente_id'] = $modelData['paciente_id'];

            return $this->save($this->table, $data);
        } else {
            $this->cancel('Nome e Número do contato é obrigatório!');
        }
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
        $data['nome']   = $modelData['nome_contato'];
        $data['numero'] = $modelData['numero_contato'];
        $data['id']     = $modelData['id_contato'];

        $this->update($this->table, $data);
    }
}
