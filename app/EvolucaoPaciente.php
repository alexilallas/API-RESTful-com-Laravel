<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvolucaoPaciente extends BaseModel
{
    protected $fillable = ['paciente_id','data', 'descricao'];
}
