<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    abstract public function customSave($data);
    
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

    public function jsonMessage($message, $code)
    {
        return response()->json(['message' => $message, 'status' => $code], $code);
    }

    public function save($table, $data)
    {
       return DB::table($table)->insert($data);
        
    }
}
