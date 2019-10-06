<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends BaseModel
{
    protected $fillable = [
        'nome','cpf_rg','telefone_celular','estado_civil','estado_naturalidade','cidade_naturalidade',
        'data_nascimento','observacao','sexo','tipo','cep','estado','cidade','bairro','logradouro', 'numero'
    ];
}
