<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    private $table = 'auditoria';

    public function find()
    {
        $registros = DB::table($this->table)->orderByRaw('data DESC')->get();

        return $this->jsonSuccess('Registros da auditoria', $registros);
    }
}
