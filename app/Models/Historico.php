<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends BaseModel
{
    protected $fillable = ['paciente_id', 'historico_familiar_id', 'historico_pessoal_id'];
}
