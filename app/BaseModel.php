<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function __construct() 
    {
        $this->fillable = array_merge($this->fillable, ['ativo','versao','deletado']);

    }
}
