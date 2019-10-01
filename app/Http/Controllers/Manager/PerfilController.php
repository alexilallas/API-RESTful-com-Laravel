<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    private $table = 'perfis';

    public function find()
    {
        $perfis = DB::table($this->table)->get();

        return $this->jsonSuccess('Perfis cadastrados', compact('perfis'));
    }

    public function findById(Request $req)
    {
        $id = $req->route('id');
        $usuario = DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->get();

        return $this->jsonSuccess('Perfil', compact('perfil'));
    }
}
