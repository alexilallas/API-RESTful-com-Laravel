<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends BaseModel
{
    protected $table = 'perfis';
    protected $fillable = ['nome','descricao','deletado'];


    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function permissoes()
    {
        return $this->belongsToMany('App\Models\Permissao');
    }
}
