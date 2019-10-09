<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvolucaoPaciente extends BaseModel
{
    protected $fillable = ['paciente_id', 'data', 'descricao', 'medico'];
}
