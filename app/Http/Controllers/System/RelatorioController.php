<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function getBase()
    {
        $anos = DB::table('exame_fisico_geral')
        ->select(DB::raw('DATE_FORMAT(data, "%Y") as ano'))
        ->orderByRaw('ano DESC')
        ->distinct()
        ->pluck('ano');

        return $this->jsonSuccess('Base', compact('anos'));
    }

    public function geraRelatorio()
    {
        $criterios = $this->jsonDecode();
        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        $relatorioAnual = [];
        $relatorioBimestral = [];

        foreach ($criterios['ano_atendimento'] as $key => $ano) {
            foreach ($meses as $key => $mes) {
                // Mês
                $frequenciaAtendimentoEnfermagem [$mes]['mes'] = $mes;
                // Funcionário
                $frequenciaAtendimentoEnfermagem [$mes]['funcionario'] = DB::table('exame_fisico_geral')
                ->join('pacientes', 'exame_fisico_geral.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.tipo', 'Funcionário')
                ->whereRaw("DATE_FORMAT(data, '%m') = ".$key)
                ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
                ->count();
                // Aluno
                $frequenciaAtendimentoEnfermagem [$mes]['aluno'] = DB::table('exame_fisico_geral')
                ->join('pacientes', 'exame_fisico_geral.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.tipo', 'Aluno')
                ->whereRaw("DATE_FORMAT(data, '%m') = ".$key)
                ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
                ->count();
                // Dependente
                $frequenciaAtendimentoEnfermagem [$mes]['dependente'] = DB::table('exame_fisico_geral')
                ->join('pacientes', 'exame_fisico_geral.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.tipo', 'Dependente')
                ->whereRaw("DATE_FORMAT(data, '%m') = ".$key)
                ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
                ->count();
                // Comunidade
                $frequenciaAtendimentoEnfermagem [$mes]['comunidade'] = DB::table('exame_fisico_geral')
                ->join('pacientes', 'exame_fisico_geral.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.tipo', 'Comunidade')
                ->whereRaw("DATE_FORMAT(data, '%m') = ".$key)
                ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
                ->count();
                // Serviço Prestado
                $frequenciaAtendimentoEnfermagem [$mes]['servico_prestado'] = DB::table('exame_fisico_geral')
                ->join('pacientes', 'exame_fisico_geral.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.tipo', 'Serviço Prestado')
                ->whereRaw("DATE_FORMAT(data, '%m') = ".$key)
                ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
                ->count();
                // Soma
                $frequenciaAtendimentoEnfermagem [$mes]['soma'] =
                $frequenciaAtendimentoEnfermagem [$mes]['funcionario']
                + $frequenciaAtendimentoEnfermagem [$mes]['aluno']
                + $frequenciaAtendimentoEnfermagem [$mes]['dependente']
                + $frequenciaAtendimentoEnfermagem [$mes]['comunidade']
                + $frequenciaAtendimentoEnfermagem [$mes]['servico_prestado'];


                $frequenciaAtendimentoConsultas [$mes] = DB::table('evolucao_pacientes')
                ->whereRaw("DATE_FORMAT(data, '%m') = ".$key)
                ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
                ->count();
            }
        }

        return $this->jsonSuccess('Gráficos', compact(['frequenciaAtendimentoEnfermagem']));
    }
}
