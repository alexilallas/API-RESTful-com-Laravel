<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{

    public function getBase()
    {
        $anos = DB::table('exame_fisico_geral')
        ->select(DB::raw('DATE_FORMAT(data, "%Y") as ano'))
        ->orderByRaw('ano DESC')
        ->distinct()
        ->pluck('ano');

        return $this->jsonSuccess('Base', \compact('anos'));
    }
}
