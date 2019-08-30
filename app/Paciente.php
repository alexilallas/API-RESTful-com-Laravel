<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends BaseModel
{
    protected $fillable = [
        'nome','cpf_rg','estado_civil','naturalidade','data_nascimento','sexo',
        'contato_id','endereco_id','exame_fisico_geral_id','evolucao_paciente_id','antecedentes_familiares_id',
        'antecedentes_pessoais_id','tipo_paciente_id'
    ];
}
