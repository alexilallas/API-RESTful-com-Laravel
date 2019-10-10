<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescricaoInterna extends BaseModel
{
    protected $fillable = ['evolucao_paciente_id', 'medicamento', 'quantidade'];
}
