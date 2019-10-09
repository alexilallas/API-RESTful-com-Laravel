<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


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
     * Retorna uma mensagem de sucesso com ou sem dados adicionais. Se não for atribuído valor ao status,
     * será por padrão 200 (OK)
     *
     * @param string $message A mensagem que será retornada
     * @param array $data Um array com informações
     *
     * @return json com uma mensagem mensagem e dados que serão consumidos pela aplicação no front-end
     */
    public function jsonSuccess($message, $data = null, $status = 200)
    {
        return response()->json(['message' => $message, 'data' => $data, 'status' => $status,]);
    }


    /**
     * Retorna uma mensagem de erro, se não for atribuído valor ao status,
     * será por padrão 400 (bad request)
     *
     * @param string $message A mensagem que será retornada
     * @param string $error o nome do erro para tratamento no front-end
     * @param int    $status o status http da resposta
     *
     * @return json  com uma mensagem que será consumida na aplicação no front-end
     */
    public function jsonError($message, $error = null, $status = 400)
    {
        return response()->json(['message' => $message, 'error' => $error, 'status' => $status]);
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
     * Verifica regra de negócio da tabela, chama método para salvar dados e
     * salva dados na tabela de auditoria
     *
     * @param array $data O dado que será salvo
     * @param string $action A ação realizada pelo usuário
     *
     * @return int $id O id da linha inserida
     */
    public function doSave($data, $action)
    {
        $this->checkBusinessLogic($data);
        $id = $this->customSave($data);
        $this->auditoria($data, $action);

        return $id;
    }


    /**
     * Cria um novo registro em uma tabela com os dados fornecidos
     *
     * @param string $table O nome da tabela que será adicionada o registro
     * @param array  $data Os dados que serão adicionados na tabela
     *
     * @return int O id da linha inserida
     */
    public function save($table, $data)
    {
        $data['created_at'] = null;
        DB::table($table)->insert($data);
        return DB::getPdo()->lastInsertId();
    }


    /**
     * Chama método para atualizar e salva dados na tabela de auditoria
     *
     * @param array $data O dado que será atualizado
     * @param string $action A ação realizada pelo usuário
     *
     */
    public function doUpdate($data, $action)
    {
        $this->customUpdate($data);
        $this->auditoria($data, $action);
    }


    /**
     * Atualiza os registros de uma linha em uma tabela e incrementa a versão da linha
     *
     * @param string $table O nome da tabela que será atualizada
     * @param array  $data Os dados que serão atualizados
     *
     */
    public function update($table, $data)
    {
        $data['updated_at'] = null;
        DB::table($table)->where('id', $data['id'])->update($data);
        DB::table($table)->where('id', $data['id'])->increment('versao');
    }


    /**
     * Salva a ação solicitada pelo usuáro usuário na tabela de auditoria
     *
     * @param int    $data Os dados que serão atualizados
     * @param string $action A ação que o usuário está realizando
     *
     * @return void
     */
    public function auditoria($data, $action)
    {
        $auditoriaData = $this->getAuditoriaData($data, $action);
        DB::table('auditoria')->insert($auditoriaData);
    }

    /**
     * Captura todos os dados que serão salvos na tabela de Auditoria
     *
     * @param array $data Os dados que foram salvos no banco
     * @param string $action A ação realizada pelo usuário
     *
     * @return array $auditoriaData Todos os dados que serão salvos na tabela de auditoria
     */
    public function getAuditoriaData($data, $action)
    {
        $user = $this->getAutenticatedUser();

        $auditoriaData = array(
            'usuario' => $user->name,
            'perfil' => $user->perfil->perfil,
            'acao' => $action,
            'dados' => json_encode($data),
            'data' => null
        );

        return $auditoriaData;
    }

    /**
     * Captura id da dada requisição
     *
     * @param Request $req A requisição enviada pelo usuário
     *
     * @return int $id O id enviado na requisição
     */
    public function getIdByRequest(Request $req)
    {
        $id = $req->route('id');
        if (!$id) {
            $id = $req->request->get('id');
        }

        return $id;
    }

    /**
     * Retorna o usuário que está logado no sistema
     * @param void
     *
     * @return App\Models\User
     */
    public function getAutenticatedUser()
    {
        $user = JWTAuth::user();
        $user->perfil = DB::table('users')
        ->join('perfil_user', 'perfil_user.user_id', '=', 'users.id')
        ->join('perfis', 'perfis.id', '=', 'perfil_user.perfil_id')
        ->select('perfis.nome as perfil')
        ->where('users.id', $user->id)
        ->first();

        return $user;
    }
}
