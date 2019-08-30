<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExameFisicoGeral extends BaseModel
{
    protected $fillable = [
        'data','pressao','altura','peso','glicemia','temperatura','frequencia_cardiaca','frequencia_respiratoria'
    ];
}
