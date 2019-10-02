<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerfilUsuarioController extends Controller
{
    private $table = 'perfil_user';

    public function customSave($modelData)
    {
        $data['perfil_id'] = $modelData['perfil_id'];
        $data['user_id']   = $modelData['user_id'];

        return $this->save($this->table, $data);
    }

    public function customUpdate($modelData)
    {
        $data['user_id']   = $modelData['id'];
        $data['perfil_id'] = $modelData['perfil_id'];
        $data['id']        = $modelData['perfil_user_id'];
        
        return $this->update($this->table, $data);
    }
}
