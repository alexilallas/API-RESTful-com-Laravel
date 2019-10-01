<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissao extends BaseModel
{
    protected $table = 'permissoes';
    protected $fillable = ['nome','descricao'];

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function perfis()
    {
        return $this->belongsToMany('App\Models\Perfil');
    }
}
