<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'medicos';

    /**
     * Customiza os dados e chama método para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        $data['crm'] = $modelData['crm'];
        $data['user_id'] = $modelData['user_id'];

        return $this->save($this->table, $data);
    }

    /**
     * Customiza os dados e chama método para atualizar
     *
     * @param array $modelData Os dados que serão atualizados
     *
     * @return void
     */
    public function customUpdate($modelData)
    {
        $data['crm'] = $modelData['crm'];
        $data['id'] = $modelData['medico_id'];

        $this->update($this->table, $data);
    }

    /**
     * Checa a regra de negócio para a uma tabela
     *
     * @param array $data Os dados que serão utilizados para a verificação
     *
     * @return void
     */
    public function checkBusinessLogic($data)
    {
        if (!isset($data['crm'])) {
            return;
        }
        $crm_user = DB::table($this->table)->where('crm', $data['crm'])->count();
        if ($crm_user > 0) {
            $this->cancel('Já existem um médico cadastrado com este CRM!');
        }
    }

    /**
     * Busca dados de um médico pelo seu id
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return App\Models\Medico
     */
    public function findById($id)
    {
        return DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->get();
    }
}
