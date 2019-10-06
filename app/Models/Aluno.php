<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends BaseModel
{
    protected $fillable = [
        'matricula','paciente_id','curso_id'
    ];
}
