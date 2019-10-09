<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    private $user;
    private $medico;
    private $perfil;
    private $enfermeiro;
    private $perfilUsuario;

    public function __construct()
    {
        $this->user = new UserController();
        $this->medico = new MedicoController();
        $this->perfil = new PerfilController();
        $this->enfermeiro = new EnfermeiroController();
        $this->perfilUsuario = new PerfilUsuarioController();

    }


    public function customSave($modelData)
    {
        $modelData['user_id'] = $this->user->customSave($modelData);
        $this->user->saveUserByPerfil($modelData);
        $this->perfilUsuario->customSave($modelData);
    }

    public function customUpdate($modelData)
    {
        $this->user->customUpdate($modelData);
        $this->user->updateUserByPerfil($modelData);
        $this->perfilUsuario->customUpdate($modelData);
    }


    public function checkBusinessLogic($data)
    {
        $this->user->checkBusinessLogic($data);
        $this->medico->checkBusinessLogic($data);
        $this->enfermeiro->checkBusinessLogic($data);
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
            $this->doSave($data, 'Criou o usuário '.$data['name']);
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
            $this->doUpdate($data, 'Editou dados do usuário '.$data['name']);
            \DB::commit();
            return $this->jsonSuccess('Usuário atualizado com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function resetPasswordUsuario()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $data['ativo'] = false;
            $data['password'] = null;
            $this->doUpdate($data, 'Resetou a senha do usuário '.$data['name']);
            \DB::commit();
            return $this->jsonSuccess('Senha resetada com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

}
