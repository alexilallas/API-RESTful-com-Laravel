<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $table = 'users';
    private $perfil;

    public function __construct()
    {
        $this->perfil = new PerfilController();
    }


    public function customSave($modelData)
    {
        $data = $modelData;

        return $this->save($this->table, $data);
    }


    public function checkBusinessLogic($data)
    {
        $email_user = DB::table($this->table)->where('email', $data['email'])->count();
        if ($email_user > 0) {
            $this->cancel('Já existem um usuário cadastrado com este email!');
        }

        $cpf_user = DB::table($this->table)->where('cpf_rg', $data['cpf_rg'])->count();
        if ($cpf_user > 0) {
            $this->cancel('Já existem um usuário cadastrado com este CPF!');
        }
    }

    public function find()
    {
        $usuarios = DB::table($this->table)
        ->join('perfil_user', 'perfil_user.user_id', '=', $this->table.'.id')
        ->join('perfis', 'perfis.id', '=', 'perfil_user.perfil_id')
        ->select($this->table.'.*', 'perfis.nome as perfil')
        ->get();

        $perfis = $this->perfil->find()->original['data']['perfis'];

        return $this->jsonSuccess('Usuários cadastrados', compact(['usuarios','perfis']));
    }

    public function findById(Request $req)
    {
        $id = $req->route('id');
        $usuario = DB::table($this->table)
        ->join('perfil_user', 'perfil_user.user_id', '=', $this->table.'.id')
        ->join('perfis', 'perfis.id', '=', 'perfil_user.perfil_id')
        ->select($this->table.'.*', 'perfis.nome as perfil')
        ->where($this->table.'.id', $id)
        ->get();

        return $this->jsonSuccess('Usuário', compact('usuario'));
    }

    public function customUpdate($modelData)
    {
        $data = $modelData;

        return $this->update($this->table, $data);
    }
}
