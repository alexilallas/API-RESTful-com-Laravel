<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContatoController extends Controller
{
    private $table = 'contatos';


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

    public function customUpdate($modelData)
    {
        $data['nome']   = $modelData['nome_contato'];
        $data['numero'] = $modelData['numero_contato'];
        $data['id']     = $modelData['id_contato'];

        return $this->update($this->table, $data);
    }
}