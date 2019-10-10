<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissaoController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'permissoes';

    /**
     * Customiza os dados e chama método para salvar
     *
     * @param array $modelData Os dados que serão salvos
     *
     * @return int o ID do elemento inserido
     */
    public function customSave($modelData)
    {
        $data = $modelData;

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
        $data = $modelData;

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
        $result = DB::table($this->table)->where('nome', $data['nome'])->count();
        if ($result > 0) {
            $this->cancel('Esta permissão já está cadastrada!');
        }
    }

    /**
     * Busca todas as permissões
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $permissoes = DB::table($this->table)->get();

        return $this->jsonSuccess('Permissões cadastradas', compact('permissoes'));
    }

    /**
     * Busca os dados de uma permissão pelo seu ID
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return json o resultado da busca
     */
    public function findById(Request $req)
    {
        $id = $req->route('id');
        $permissao = DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->get();

        return $this->jsonSuccess('Permissao '.$id.'', compact('permissao'));
    }

    /**
     * Adiciona uma permissão na tabela de permissoes
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function postPermissao()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doSave($data, 'criarPermissao');
            \DB::commit();
            return $this->jsonSuccess('Permissão adicionada com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    /**
     * Atualiza os dados de uma permissão
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function updatePermissao()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $this->doUpdate($data, 'editarPermissao');
            \DB::commit();
            return $this->jsonSuccess('Permissão atualizada com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }
}
