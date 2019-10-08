<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $table = 'users';
    private $perfil;
    private $medico;
    private $enfermeiro;

    public function __construct()
    {
        $this->perfil = new PerfilController();
        $this->medico = new MedicoController();
        $this->enfermeiro = new EnfermeiroController();
    }


    public function customSave($modelData)
    {
        $data['name']     = $modelData['name'];
        $data['email']    = $modelData['email'];
        $data['cpf']      = $modelData['cpf'];
        $data['ativo']    = false;

        return $this->save($this->table, $data);
    }


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

    public function saveUserByPerfil($modelData)
    {
        //Enfermeiro
        if ($modelData['perfil_id'] == 3 && isset($modelData['coren'])) {
            $this->enfermeiro->customSave($modelData);
        }
        //Médico
        if ($modelData['perfil_id'] == 4 && isset($modelData['crm'])) {
            $this->medico->customSave($modelData);
        }
    }

    public function updateUserByPerfil($modelData)
    {
        //Enfermeiro
        if ($modelData['perfil_id'] == 3 && isset($modelData['coren'])) {
            if (isset($modelData['enfermeiro_id'])) {
                $this->enfermeiro->customUpdate($modelData);
            } else {
                $this->cancel('Este usuário não pode ser cadastrado como Enfermeiro!');
            }
        }
        //Médico
        if ($modelData['perfil_id'] == 4 && isset($modelData['crm'])) {
            if (isset($modelData['medico_id'])) {
                $this->medico->customUpdate($modelData);
            } else {
                $this->cancel('Este usuário não pode ser cadastrado como Médico!');
            }
        }
    }
}
