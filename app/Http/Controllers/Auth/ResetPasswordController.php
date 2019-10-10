<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public $table = 'users';
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Verifica se a senha de um usuário pode ser resetada
     *
     * @param void
     *
     * @return json A mensagem indicando se a senha pode ser resetada
     */
    public function canResetPassword()
    {
        $data = $this->jsonDecode();
        $user = DB::table($this->table)
        ->where('cpf', $data['cpf'])
        ->where('email', $data['email'])
        ->where('password', null)
        ->select('id')
        ->first();

        if ($user) {
            return $this->jsonSuccess('Pode resetar a senha!', $user);
        } else {
            return $this->jsonError('Não existe requisição de redefinição de senha para este usuário!', 403);
        }
    }

    /**
     * Redefine a senha de um usuário
     *
     * @param void
     *
     * @return json a mensagem descrevendo o resultado da operação
     */
    public function resetPassword()
    {
        $data = $this->jsonDecode();
        $userData['password'] = Hash::make($data['password']);
        $userData['ativo'] = true;

        try {
            \DB::beginTransaction();
            DB::table($this->table)->where('id', $data['id'])
            ->update($userData);
            \DB::commit();
            return $this->jsonSuccess('Senha redefinida com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }
}
