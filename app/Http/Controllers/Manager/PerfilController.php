<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'perfis';

    /**
     * Busca todos os perfis cadastrados
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $perfis = DB::table($this->table)->get();

        return $this->jsonSuccess('Perfis cadastrados', compact('perfis'));
    }

    /**
     * Busca de um perfil pelo seu id
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return App\Models\Perfil
     */
    public function findById(Request $req)
    {
        $id = $req->route('id');
        $usuario = DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->get();

        return $this->jsonSuccess('Perfil', compact('perfil'));
    }
}
