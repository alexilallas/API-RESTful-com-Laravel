<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends BaseModel
{
    protected $fillable = [
        'cep','logradouro','bairro','cidade','uf'
    ];
}
