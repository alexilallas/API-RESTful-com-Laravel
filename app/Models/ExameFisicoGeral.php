<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExameFisicoGeral extends BaseModel
{
    protected $fillable = [
        'paciente_id', 'data', 'pressao', 'altura', 'peso', 'glicemia', 'temperatura',
        'frequencia_cardiaca', 'frequencia_respiratoria', 'enfermeiro'
    ];
}
