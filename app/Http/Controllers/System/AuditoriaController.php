<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'auditoria';

    /**
     * Retorna todos os dados da tabela de auditoria
     *
     * @param void
     *
     * @return App\Models\Auditoria
     */
    public function find()
    {
        $registros = DB::table($this->table)->orderByRaw('data DESC')->get();

        return $this->jsonSuccess('Registros da auditoria', $registros);
    }
}
