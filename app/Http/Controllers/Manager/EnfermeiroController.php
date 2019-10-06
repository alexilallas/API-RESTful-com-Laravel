<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EnfermeiroController extends Controller
{
    private $table = 'enfermeiros';

    public function checkBusinessLogic($data)
    {
        if (!isset($data['coren'])) {
            return true;
        }
        $crm_user = DB::table($this->table)->where('coren', $data['coren'])->count();
        if ($crm_user > 0) {
            $this->cancel('Já existem um enfermeiro cadastrado com este COREN!');
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
        $data['coren'] = $modelData['coren'];
        $data['user_id'] = $modelData['user_id'];

        return $this->save($this->table, $data);
    }

    public function customUpdate($modelData)
    {
        $data['coren'] = $modelData['coren'];
        $data['id'] = $modelData['enfermeiro_id'];

        return $this->update($this->table, $data);
    }
}
