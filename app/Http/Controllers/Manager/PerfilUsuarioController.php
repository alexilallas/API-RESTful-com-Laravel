<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerfilUsuarioController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'perfil_user';

    /**
     * Customiza os dados e chama método para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        $data['perfil_id'] = $modelData['perfil_id'];
        $data['user_id']   = $modelData['user_id'];

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
        $data['user_id']   = $modelData['id'];
        $data['perfil_id'] = $modelData['perfil_id'];
        $data['id']        = $modelData['perfil_user_id'];

        $this->update($this->table, $data);
    }
}
