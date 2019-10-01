<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissao extends BaseModel
{
    protected $table = 'permissoes';
    protected $fillable = ['nome','descricao','deletado'];

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
        return $this->belongsToMany('App\Perfil');
    }
}
