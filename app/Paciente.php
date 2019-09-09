<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends BaseModel
{
    protected $fillable = [
        'nome','cpf_rg','estado_civil','naturalidade','data_nascimento','sexo','cep','logradouro','bairro','cidade','uf'
    ];
}
