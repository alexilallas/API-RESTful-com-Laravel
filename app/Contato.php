<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends BaseModel
{
    protected $fillable = [ 
        'nome','numero','paciente_id'
    ];
}
