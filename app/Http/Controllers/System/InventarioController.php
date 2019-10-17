<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * @var string Nome da tabela que está diretamente relacionada à este controller
     */
    private $table = 'inventario';

    /**
     * Customiza os dados e chama métodos para salvar
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

        return $this->update($this->table, $data);
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
        $result = DB::table($this->table)
        ->whereRaw('LOWER(`nome`) LIKE ? ', [trim(strtolower($data['nome'])).'%'])
        ->where('tipo', $data['tipo'])
        ->count();

        if ($result > 0) {
            $this->cancel('Este item já está cadastrado!');
        }
    }

    /**
     * Busca todos os itens do inventário
     *
     * @param void
     *
     * @return json O resultado da busca
     */
    public function find()
    {
        $itens = DB::table($this->table)->whereNull('deleted_at')->get();

        return $this->jsonSuccess('Itens cadastrados', compact('itens'));
    }

    /**
     * Busca os dados de um item pelo seu ID
     *
     * @param Request $req A requisição do usuário que terá o ID
     *
     * @return json o resultado da busca
     */
    public function findById(Request $req)
    {
        $id = $req->route('id');
        $item = DB::table($this->table)
        ->where($this->table.'.id', $id)
        ->first();

        return $this->jsonSuccess('Item '.$id.'', compact('item'));
    }

    /**
     * Adiciona um item ao inventário
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function postItem()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $data['nome'] = strtoupper(\removeAcentos($data['nome']));
            $this->doSave($data, 'Criou o item '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Item adicionado com sucesso!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    /**
     * Atualiza o histórico médico de um paciente
     *
     * @param void
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function updateItem()
    {
        $data = $this->jsonDecode();

        try {
            \DB::beginTransaction();
            $data['nome'] = strtoupper(\removeAcentos($data['nome']));
            $this->doUpdate($data, 'Editou o item '.$data['nome']);
            \DB::commit();
            return $this->jsonSuccess('Item atualizado com sucesso!', $data);
        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }

    /**
     * Decrementa a dose de um item do inventário
     *
     * @param string $nome O nome do item
     * @param int $dose A quantidade a ser decrementada
     *
     * @return boolean o resultado da operação
     */
    public function decrement($nome, $dose)
    {
        return DB::table($this->table)->where('nome', $nome)
        ->decrement('dose', $dose);
    }

    /**
     * Incrementa a dose de um item do inventário
     *
     * @param string $nome O nome do item
     * @param int $dose A quantidade a ser incrementada
     *
     * @return boolean o resultado da operação
     */
    public function increment($nome, $dose)
    {
        return DB::table($this->table)->where('nome', $nome)
        ->increment('dose', $dose);
    }

    /**
     * Customiza o método de excluir, possibilitanto por exemplo
     * chamar outros métodos para que excluam dados de outras
     * tabelas
     *
     * @param array $id O ID da linha a ser excluída
     *
     * @return void
     */
    public function customDelete($id)
    {
        $this->delete($this->table, $id);
    }

    /**
     * Remove uma linha da tabela e retorna um json
     *
     * @param int $id O ID da linha a ser removida
     *
     * @return json Uma mensagem descrevendo o resultado da operação
     */
    public function deleteItem($id)
    {
        try {
            \DB::beginTransaction();
            $this->doDelete($id, "Excluiu o item {$id}");
            \DB::commit();
            return $this->jsonSuccess('Item excluído com sucesso!');

        } catch (\Throwable $th) {
            \DB::rollback();
            return $this->jsonError($th->getMessage());
        }
    }
}
