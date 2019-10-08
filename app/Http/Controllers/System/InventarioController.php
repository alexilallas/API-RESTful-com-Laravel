<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    private $table = 'inventario';


    public function customSave($modelData)
    {
        $data = $modelData;

        return $this->save($this->table, $data);
    }


    public function checkBusinessLogic($data)
    {
        $result = DB::table($this->table)->where('nome', $data['nome'])->count();
        if ($result > 0) {
            $this->cancel('Este item já está cadastrado!');
        }
    }

    public function find()
    {
        $itens = DB::table($this->table)->get();

        return $this->jsonSuccess('Itens cadastrados', compact('itens'));
    }

    public function findById(Request $req)
    {
        $id = $req->route('id');
        $item = DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->first();

        return $this->jsonSuccess('Item '.$id.'', compact('item'));
    }

    public function postItem()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'Criou o item '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Item adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    public function updateItem()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'Editou o item '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Item atualizado com sucesso!', $data);
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
