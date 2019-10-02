<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name','email','cpf','password'
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Checks a Permission
     *
     * @param  String permission Slug of a permission (i.e: manage_user)
     * @return Boolean true if has permission, otherwise false
     */
    public function userCan($permission = null)
    {
        return !is_null($permission) && $this->checkPermission($permission);
    }

    /**
     * Check if the permission matches with any permission user has
     *
     * @param  String permission slug of a permission
     * @return Boolean true if permission exists, otherwise false
     */
    protected function checkPermission($perm)
    {
        $permissions = $this->getAllPernissionsFormUser();

        $permissionArray = is_array($perm) ? $perm : [$perm];

        return count(array_intersect($permissions, $permissionArray));
    }

    /**
     * Get all permission slugs from all permissions of user role
     *
     * @return Array of permission slugs
     */
    protected function getAllPernissionsFormUser()
    {
        $permissionsArray = [];
        return array_pluck($this->getPermissoesUserLoggedIn(), 'nome');
    }

    /**
     * Get all permission slugs from all permissions loggedIn
     *
     * @return Array of permission slugs and role name
     */
    public function getPermissoesUserLoggedIn()
    {
        return DB::table('users')
        ->join('perfil_user', 'users.id', '=', 'perfil_user.user_id')
        ->join('perfis', 'perfil_user.perfil_id', '=', 'perfis.id')
        ->join('perfil_permissao', 'perfil_user.perfil_id', '=', 'perfil_permissao.perfil_id')
        ->join('permissoes', 'perfil_permissao.permissao_id', '=', 'permissoes.id')
        ->select('perfis.nome', 'permissoes.nome')->where([['users.id', '=', auth()->user()->id],['perfil_permissao.ativo','=', 1]])
        ->distinct()
        ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Many-To-Many Relationship Method for accessing the User->Perfil
     *
     * @return QueryBuilder Object
     */
    public function perfis()
    {
        return $this->belongsToMany('App\Models\Perfil');
    }
}
