<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnderecoController extends Controller
{
    private $tabela = 'enderecos';

    public function customSave($modelData)
    {
        //implementar validação dos campos
        if(isset($modelData['cep'])){
            $data['cep']        = $modelData['cep'];
            $data['logradouro'] = $modelData['logradouro'];
            $data['bairro']     = $modelData['bairro'];
            $data['cidade']     = $modelData['cidade'];
            $data['uf']         = $modelData['uf'];
            return $this->save($this->tabela, $data);
        }
        else{
            abort(400, 'Campo CEP obrigatório!');
        }

    }
}
