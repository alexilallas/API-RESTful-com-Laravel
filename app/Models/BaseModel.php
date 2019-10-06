<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, ['ativo','versao']);

    }
}
