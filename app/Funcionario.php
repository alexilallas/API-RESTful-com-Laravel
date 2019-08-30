<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends BaseModel
{
    protected $fillable= [
        'matricula','paciente_id','setor_id'
    ];
}
