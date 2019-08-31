<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PacienteController extends Controller
{
    public function getPacientes()
    {
        $users = User::all();

        return response()->success(compact('users'));
    }
}
