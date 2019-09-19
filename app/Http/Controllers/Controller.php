<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use App\Paciente;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    abstract public function customSave($modelData);
    abstract public function customUpdate($modelData);
    abstract public function checkBusinessLogic($data);

    protected function formatValidationErrors(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $status = 422;
        return [
            "message" => $status . " error",
            "errors" => [
                "message" => $validator->getMessageBag()->first(),
                "info" => [$validator->getMessageBag()->keys()[0]],
            ],
            "status_code" => $status
        ];
    }

    
    /**
     * Captura dados json que são lançados da aplicação no front-end e decodifica
     *
     * @param void
     *
     * @return array $data com os dados
     */
    public function jsonDecode()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        return $data;
    }


    /**
     * Retorna uma mensagem de sucesso 200 (OK) com ou sem dados adicionais
     *
     * @param string $message A mensagem que será retornada
     * @param array $data Um array com informações
     *
     * @return json com uma mensagem mensagem e dados que serão consumidos pela aplicação no front-end
     */
    public function jsonSuccess($message, $data = null)
    {
        return response()->json(['message' => $message, 'status' => 200, 'data' => $data]);
    }


    /**
     * Retorna uma mensagem com status de error 400 (bad request)
     *
     * @param string $message A mensagem que será retornada
     *
     * @return json  com uma mensagem que será consumida na aplicação no front-end
     */
    public function jsonError($message)
    {
        return response()->json(['message' => $message, 'status' => 400]);
    }

    
    /**
     * Lança uma excessão abortando qualquer operação
     *
     * @param string $message A mensagem passada ao abortar uma operação
     *
     * @return void
     */
    public function cancel($message = null)
    {
        abort(400, $message);
    }


    /**
     * Verifica se determinado usuário tem permissão para fazer atualização e chama a função de salvar
     *
     * @param array $data O dado que será salvo
     * @param string $permission A permissão solicitada pelo usuário
     *
     * @return boolean Indica se a ação obteve êxito ou não
     */
    public function doSave($data, $permission)
    {
        $this->verifyPermission($permission);
        $this->checkBusinessLogic($data);
        return $this->customSave($data);
    }


    /**
     * Cria um novo registro em uma tabela com os dados fornecidos
     *
     * @param string $table O nome da tabela que será adicionada o registro
     * @param array  $data Os dados que serão adicionados na tabela
     *
     * @return boolean Indica se a ação obteve êxito ou não
     */
    public function save($table, $data)
    {
        //fazer a auditoria
        $this->coreSave($table, 'Criação', $id = null);
        return DB::table($table)->insert($data);
    }


    /**
     * Salva a ação solicitada pelo usuáro usuário na tabela de auditoria
     *
     * @param string $table A tabela na qual será realizada a inserção do dado
     * @param string $action A ação que o usuário está criando
     * @param int    $idLine O ID da linha que será criada
     *
     * @return void
     */
    public function coreSave($table, $action, $idLine)
    {
        //incrementa a versão e salva na tabela de auditoria
        //DB::table($table)->increment('versao', 1, ['id' => $idLine]);
        //salva registro para auditoria
        //$data['usuario']
        //Auditoria::create($data)
    }


    /**
     * Verifica se determinado usuário tem permissão para fazer atualização e chama a função de atualizar
     *
     * @param array $data O dado que será atualizado
     * @param string $permission A permissão solicitada pelo usuário
     *
     * @return boolean Indica se a ação obteve êxito ou não
     */
    public function doUpdate($data, $permission)
    {
        $this->verifyPermission($permission);
        return $this->customUpdate($data);
    }


    /**
     * Atualiza os registros de uma linha em uma tabela
     *
     * @param string $table O nome da tabela que será atualizada
     * @param array  $data Os dados que serão atualizados
     *
     * @return boolean Indica se a ação obteve êxito ou não
     */
    public function update($table, $data)
    {
        $this->coreUpdate($table, 'Atualização', $id = null);
        return DB::table($table)->where('id', $data['id'])->update($data);
    }


    /**
     * Salva a ação solicitada pelo usuáro usuário na tabela de auditoria e incrementa a versão da row que será atualizada
     *
     * @param string $table A tabela na qual será realizada a atualização do dado
     * @param string $action A ação que o usuário está realizando
     * @param int    $idLine O ID da linha que será atualizada
     *
     * @return void
     */
    public function coreUpdate($table, $action, $idLine)
    {
        //incrementa a versão e salva na tabela de auditoria
        //DB::table($table)->increment('versao', 1, ['id' => $idLine]);
        //salva registro para auditoria
        //$data['usuario']
        //Auditoria::create($data)
    }


    /**
     * Verifica se o usuário logado tem determinada permissão
     *
     * @param string $permission O nome da permissão a ser verificada
     *
     * @return boolean Indica se o usuário tem a permissão ou não
     */
    public function verifyPermission($permission)
    {
        // verification
    }
}
