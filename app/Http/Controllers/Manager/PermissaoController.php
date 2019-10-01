<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissaoController extends Controller
{
    private $table = 'permissoes';
    
    
    public function customSave($modelData)
    {
        $data = $modelData;

        return $this->save($this->table, $data);
    }


    public function checkBusinessLogic($data)
    {
        $result = DB::table($this->table)->where('nome', $data['nome'])->count();
        if ($result > 0) {
            $this->cancel('Esta permissão já está cadastrada!');
        }
    }

    public function find()
    {
        $permissoes = DB::table($this->table)->get();

        return $this->jsonSuccess('Permissões cadastradas', compact('permissoes'));
    }

    public function findById(Request $req)
    {
        $id = $req->route('id');
        $permissao = DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->get();

        return $this->jsonSuccess('Permissao '.$id.'', compact('permissao'));
    }

    public function postPermissao()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'criarPermissao');
            \DB::commit();
            return $this->jsonSuccess('Permissão adicionada com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function updatePermissao()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'editarPermissao');
            \DB::commit();
            return $this->jsonSuccess('Permissão atualizada com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function customUpdate($modelData)
    {
        $data = $modelData;

        return $this->update($this->table, $data);
    }
}
