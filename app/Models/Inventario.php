<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends BaseModel
{
    protected $fillable = ['nome', 'tipo', 'dose', 'descricao'];
}
