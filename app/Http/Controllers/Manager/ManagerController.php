<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    /**
     * @var UserController
     */
    private $user;

    /**
     * @var MedicoController
     */
    private $medico;

    /**
     * @var PerfilController
     */
    private $perfil;

    /**
     * @var EnfermeiroController
     */
    private $enfermeiro;

    /**
     * @var PerfilUsuarioController
     */
    private $perfilUsuario;

    public function __construct()
    {
        $this->user = new UserController();
        $this->medico = new MedicoController();
        $this->perfil = new PerfilController();
        $this->enfermeiro = new EnfermeiroController();
        $this->perfilUsuario = new PerfilUsuarioController();
    }

    /**
     * Customiza os dados e chama métodos para salvar o usuário e seu perfil
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        $modelData['user_id'] = $this->user->customSave($modelData);
        $this->user->saveUserByPerfil($modelData);
        $this->perfilUsuario->customSave($modelData);
    }

    /**
     * Customiza os dados e chama métodos para atualizar o usuário e seu perfil
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
    public function customUpdate($modelData)
    {
        $this->user->customUpdate($modelData);
        $this->user->updateUserByPerfil($modelData);
        $this->perfilUsuario->customUpdate($modelData);
    }

    /**
     * Checa a regra de negócio para as tabelas de usuario, medico e enfermeiro
     *
     * @param array $data Os dados que serão utilizados para a verificação
     *
     * @return void
     */
    public function checkBusinessLogic($data)
    {
        $this->user->checkBusinessLogic($data);
        $this->medico->checkBusinessLogic($data);
        $this->enfermeiro->checkBusinessLogic($data);
    }

    /**
     * Busca todos os usuários
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $usuarios = $this->user->find()->original['data']['usuarios'];
        $perfis = $this->perfil->find()->original['data']['perfis'];

        return $this->jsonSuccess('Usuários cadastrados', compact(['usuarios','perfis']));
    }

    /**
     * Busca os dados de um usuário pelo seu ID
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return json o resultado da busca
     */
    public function findById(Request $req)
    {
        $usuario = $this->user->findById($req)->original['data']['usuario'];

        return $this->jsonSuccess('Usuário', compact('usuario'));
    }

    /**
     * Adiciona um usuário ao sistema
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
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

    /**
     * Atualiza os dados de um usuário
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
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

    /**
     * Define o status do usuário ativo = false e password = null
     * para permitir que ele resete a senha
     *
     * @param void
     *
     * @return json com o resultado da operação
     */
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
