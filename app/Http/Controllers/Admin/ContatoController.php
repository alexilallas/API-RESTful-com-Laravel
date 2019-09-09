<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContatoController extends Controller
{
    private $tabela = 'contatos';

    public function customSave($modelData)
    {
        if(isset($modelData['nome_contato']) && isset($modelData['numero_contato'])){
            $data['nome'] = $modelData['nome_contato'];
            $data['numero'] = $modelData['numero_contato'];
            return $this->save($this->tabela, $data);
        }
        else{
            abort(400, 'Nome e Número do contato é obrigatório!');
        }

    }
}
