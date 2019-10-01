<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends BaseModel
{
    protected $table = 'perfil_user';

    protected $fillable = [
        'perfil_id', 'user_id','deletado'
    ];
}
