<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    private $user;
    private $perfil;
    private $permissao;
    private $perfilUsuario;
    private $perfilPermissao;

    public function __construct()
    {
        $this->user = new UserController();
        $this->perfil = new PerfilController();
        $this->perfilUsuario = new PerfilUsuarioController();
        $this->perfilPermissao = new PermissaoPerfilController();
    }


    public function customSave($modelData)
    {
        $this->user->customSave($modelData);
        $this->perfilUsuario->customSave($modelData);
    }

    public function customUpdate($modelData)
    {
        $this->user->customUpdate($modelData);
        $this->perfilUsuario->customUpdate($modelData);
    }


    public function checkBusinessLogic($data)
    {
        $this->user->checkBusinessLogic($data);
    }

    public function find()
    {
        $usuarios = $this->user->find()->original['data']['usuarios'];

        $perfis = $this->perfil->find()->original['data']['perfis'];

        return $this->jsonSuccess('Usuários cadastrados', compact(['usuarios','perfis']));
    }

    public function findById(Request $req)
    {
        $usuario = $this->user->findById($req)->original['data']['usuario'];

        return $this->jsonSuccess('Usuário', compact('usuario'));
    }

    public function postUsuario()
    {
        $data = $this->jsonDecode();
        
        try {
            \DB::beginTransaction();
            $this->user->customSave($data);
            $idUsuario = DB::getPdo()->lastInsertId();
            $data['user_id'] = $idUsuario;
            $this->perfilUsuario->customSave($data);
            \DB::commit();
            return $this->jsonSuccess('Usuário adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function updateUsuario()
    {
        $data = $this->jsonDecode();
        
        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'editarUsuario');
            \DB::commit();
            return $this->jsonSuccess('Usuário atualizado com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

}
