<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends BaseModel
{
    protected $fillable = [
        'usuario', 'perfil', 'acao', 'data', 'dados'
    ];
}
