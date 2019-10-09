<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoFamiliar extends BaseModel
{
    protected $fillable = [
        'diabetes','hipertensao','infarto','morte_subita','cancer','outro'
    ];
}
