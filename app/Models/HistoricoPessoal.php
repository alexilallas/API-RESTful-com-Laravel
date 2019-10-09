<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoPessoal extends BaseModel
{
    protected $fillable = [
        'fumante','quantidade_cigarros','alcool','frequencia_alcool','atividade_fisica','nome_atividade',
        'hipertenso','diabetico','fator_rh','alergico','nome_alergia','cirurgia','nome_cirurgia',
        'usa_medicamento','nome_medicamento','preventivo_psa','vacina_dt','vacina_hb',
        'vacina_fa','vacina_influenza','vacina_antirrabica','mora_sozinho','problema_familiar'
    ];
}
