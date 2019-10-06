<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    private $table = 'medicos';

    public function checkBusinessLogic($data)
    {
        if (!isset($data['crm'])) {
            return true;
        }
        $crm_user = DB::table($this->table)->where('crm', $data['crm'])->count();
        if ($crm_user > 0) {
            $this->cancel('Já existem um médico cadastrado com este CRM!');
        }
    }

    public function findById($id)
    {
        return DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->get();
    }

    public function customSave($modelData)
    {
        $data['crm'] = $modelData['crm'];
        $data['user_id'] = $modelData['user_id'];

        return $this->save($this->table, $data);
    }

    public function customUpdate($modelData)
    {
        $data['crm'] = $modelData['crm'];
        $data['id'] = $modelData['medico_id'];

        return $this->update($this->table, $data);
    }
}
