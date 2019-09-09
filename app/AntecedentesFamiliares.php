<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntecedentesFamiliares extends BaseModel
{
    protected $fillable = [
        'paciente_id','diabetes','hipertensao','infarto','morte_subita','cancer','outro'
    ];
}
