<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends BaseModel
{
    protected $table = 'perfil_user';

    protected $fillable = [
        'perfil_id', 'user_id'
    ];
}
