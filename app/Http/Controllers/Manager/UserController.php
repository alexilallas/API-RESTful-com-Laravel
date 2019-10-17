<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'users';

    /**
     * @var PerfilController
     */
    private $perfil;

    /**
     * @var MedicoController
     */
    private $medico;

    /**
     * @var EnfermeiroController
     */
    private $enfermeiro;

    public function __construct()
    {
        $this->perfil = new PerfilController();
        $this->medico = new MedicoController();
        $this->enfermeiro = new EnfermeiroController();
    }

    /**
     * Customiza os dados e chama métodos para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        $data['name']     = $modelData['name'];
        $data['email']    = $modelData['email'];
        $data['cpf']      = $modelData['cpf'];
        $data['ativo']    = false;

        return $this->save($this->table, $data);
    }

    /**
     * Customiza os dados e chama métodos para atualizar
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
    public function customUpdate($modelData)
    {
        $data['id']       = $modelData['id'];
        $data['name']     = $modelData['name'];
        $data['email']    = $modelData['email'];
        $data['cpf']      = $modelData['cpf'];
        $data['password'] = $modelData['password'];
        $data['ativo']    = $modelData['ativo'];

        return $this->update($this->table, $data);
    }

    /**
     * Checa a regra de negócio para a uma tabela
     *
     * @param array $data Os dados que serão utilizados para a verificação
     *
     * @return void
     */
    public function checkBusinessLogic($data)
    {
        $email_user = DB::table($this->table)->where('email', $data['email'])->count();
        if ($email_user > 0) {
            $this->cancel('Já existem um usuário cadastrado com este email!');
        }

        $cpf_user = DB::table($this->table)->where('cpf', $data['cpf'])->count();
        if ($cpf_user > 0) {
            $this->cancel('Já existem um usuário cadastrado com este CPF!');
        }
    }

    /**
     * Busca todos os usuários cadastrados
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $usuarios = DB::table($this->table)
        ->join('perfil_user', 'perfil_user.user_id', '=', $this->table.'.id')
        ->join('perfis', 'perfis.id', '=', 'perfil_user.perfil_id')
        ->select($this->table.'.*', 'perfis.nome as perfil')
        ->whereNull($this->table.'.deleted_at')
        ->get();

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
        $id = $req->route('id');
        $usuario = DB::table($this->table)
        ->join('perfil_user', 'perfil_user.user_id', '=', $this->table.'.id')
        ->join('perfis', 'perfis.id', '=', 'perfil_user.perfil_id')
        ->leftJoin('medicos', 'medicos.user_id', '=', 'users.id')
        ->leftJoin('enfermeiros', 'enfermeiros.user_id', '=', 'users.id')
        ->select(
            $this->table.'.*',
            'perfis.id as perfil_id',
            'perfis.nome as perfil',
            'perfil_user.id as perfil_user_id',
            'medicos.id as medico_id',
            'medicos.crm',
            'enfermeiros.id as enfermeiro_id',
            'enfermeiros.coren'
        )
        ->where($this->table.'.id', $id)
        ->first();

        return $this->jsonSuccess('Usuário', compact('usuario'));
    }

    /**
     * Chama método para salvar dados do usuário de acordo com o seu perfil
     *
     * @param array $modelData Os dados do usuário
     *
     * @return void
     */
    public function saveUserByPerfil($modelData)
    {
        // Salva dados do Enfermeiro
        if ($modelData['perfil_id'] == 3 && isset($modelData['coren'])) {
            $this->enfermeiro->customSave($modelData);
        }
        // Salva dados do Médico
        if ($modelData['perfil_id'] == 4 && isset($modelData['crm'])) {
            $this->medico->customSave($modelData);
        }
    }

    /**
     * Chama método para atualizar os dados do usuário de acordo com o seu perfil
     *
     * @param array $modelData Os dados do usuário
     *
     * @return void
     */
    public function updateUserByPerfil($modelData)
    {
        // Atualiza dados do Enfermeiro
        if ($modelData['perfil_id'] == 3 && isset($modelData['coren'])) {
            if (isset($modelData['enfermeiro_id'])) {
                $this->enfermeiro->customUpdate($modelData);
            } else {
                $this->cancel('Este usuário não pode ser cadastrado como Enfermeiro!');
            }
        }
        // Atualiza dados do Médico
        if ($modelData['perfil_id'] == 4 && isset($modelData['crm'])) {
            if (isset($modelData['medico_id'])) {
                $this->medico->customUpdate($modelData);
            } else {
                $this->cancel('Este usuário não pode ser cadastrado como Médico!');
            }
        }
    }

    /**
     * Customiza o método de excluir, possibilitanto por exemplo
     * chamar outros métodos para que excluam dados de outras
     * tabelas
     *
     * @param array $id O ID da linha a ser excluída
     *
     * @return void
     */
    public function customDelete($id)
    {
        $this->delete($this->table, $id);
    }
}
