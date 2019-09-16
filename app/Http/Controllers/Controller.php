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

    abstract public function customSave($data);
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

    public function jsonDecode()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        return $data;
    }

    public function jsonSuccess($message, $data = null)
    {
        return response()->json(['message' => $message, 'status' => 200, 'data' => $data]);
    }

    public function jsonError($message)
    {
        return response()->json(['message' => $message, 'status' => 400]);
    }

    public function cancel($message = null)
    {
        abort(400, $message);
    }

    public function doSave($data, $permission){
        $this->verifyPermission($permission);
        $this->checkBusinessLogic($data);
        return $this->customSave($data);
    }

    public function save($table, $data)
    {
        //fazer a auditoria
        $this->coreSave($table, 'Criação', $id = NULL);
        return DB::table($table)->insert($data);

    }

    //Salvar dados na tabela de Auditoria
    public function coreSave($table, $action , $idLine)
    {
        //incrementa a versão e salva na tabela de auditoria
        //DB::table($table)->increment('versao', 1, ['id' => $idLine]);
        //salva registro para auditoria
        //$data['usuario']
        //Auditoria::create($data)
    }


    public function verifyPermission($permissao)
    {
        //verification
    }
}
