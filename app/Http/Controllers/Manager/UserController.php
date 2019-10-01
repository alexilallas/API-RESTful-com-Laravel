<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $table = 'users';
    private $contato;

    public function __construct()
    {
        $this->contato = new ContatoController();
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
        $usuarios = DB::table($this->table)->get();

        return $this->jsonSuccess('Usuários cadastrados', compact('usuarios'));
    }

    public function findById(Request $req)
    {
        $id = $req->route('id');
        $usuario = DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->get();

        return $this->jsonSuccess('Usuário', compact('usuario'));
    }

    public function postUsuario()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'criarUsuario');
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

    public function customUpdate($modelData)
    {
        unset($modelData['nome_contato']);
        unset($modelData['numero_contato']);
        unset($modelData['tipo_paciente']);
        unset($modelData['id_contato']);
        $data = $modelData;

        return $this->update($this->table, $data);
    }
}
