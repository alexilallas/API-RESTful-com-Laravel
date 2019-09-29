<?php

namespace App\Http\Controllers\JWT;

use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $login['email'] = 'user@gmail.com';
        //$login['password'] = '123456';
        $login['password'] = $credentials['senha'];

        if (!$token = $this->jwtAuth->attempt($login)) {
            return $this->jsonError('Login Inválido', 'invalid_credentials', 401);
        }

        $user = $this->jwtAuth->user();

        return $this->jsonSuccess('Seja bem vindo, '.$user['name'].'!', ['token' => $token, 'user' => $user]);
    }

}
