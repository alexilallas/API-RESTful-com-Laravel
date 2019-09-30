<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends BaseModel
{
    protected $fillable = ['nome', 'quantidade', 'descricao'];
}
