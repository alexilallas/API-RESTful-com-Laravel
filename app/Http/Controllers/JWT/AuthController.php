<?php

namespace App\Http\Controllers\JWT;

use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * @var JWTAuth
     */
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function login(Request $request)
    {
        $credentials = $this->jsonDecode();
        
        if (!$token = $this->jwtAuth->attempt($credentials)) {
            return $this->jsonError('Login Inválido', 'invalid_credentials', 401);
        }

        $user = $this->jwtAuth->user();
        
        $permissions = DB::table('users')
        ->join('perfil_user', 'perfil_user.user_id', '=', 'users.id')
        ->join('perfis', 'perfis.id', '=', 'perfil_user.perfil_id')
        ->join('perfil_permissao', 'perfil_permissao.perfil_id', '=', 'perfis.id')
        ->join('permissoes', 'permissoes.id', '=', 'perfil_permissao.permissao_id')
        ->select('permissoes.id', 'permissoes.nome', 'permissoes.descricao', 'perfis.nome as perfil')
        ->where('users.id', $user->id)
        ->get();
        
        $user->perfil = $permissions[0]->perfil;

        $permissionWorked = [];
        foreach ($permissions->toArray() as $permission) {
            $permissionWorked[] = $permission->nome;
        }

        return $this->jsonSuccess(
            "Seja bem vindo, $user->name",
            [
            'token' => $token,
            'user' => $user,
            'permissoes' => $permissionWorked
            ]
        );
    }

    public function logout()
    {
        $token = $this->jwtAuth->getToken();
        $this->jwtAuth->invalidate($token);
        return $this->jsonSuccess('Logout');
    }
}
