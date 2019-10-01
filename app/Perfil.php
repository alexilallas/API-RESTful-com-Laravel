<?php

namespace App;

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
        return $this->belongsToMany('App\User');
    }

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function permissoes()
    {
        return $this->belongsToMany('App\Permissao');
    }
}
