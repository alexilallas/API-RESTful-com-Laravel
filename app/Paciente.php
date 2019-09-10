<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends BaseModel
{
    protected $fillable = [
        'nome','cpf_rg','telefone_celular','estado_civil','estado_naturalidade','cidade_naturalidade','data_nascimento','sexo','cep','estado','cidade','bairro','logradouro', 'numero'
    ];
}
