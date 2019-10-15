<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /**
     * Esta função retorna todos os anos que possuem Exame Físico registrado
     * para ser mostrado no select options da tela de Relatórios
     * 
     * @param void
     * 
     * @return json O resultado da consulta
     */
    public function getBase()
    {
        $anos = DB::table('exame_fisico_geral')
        ->select(DB::raw('DATE_FORMAT(data, "%Y") as ano'))
        ->orderByRaw('ano DESC')
        ->distinct()
        ->pluck('ano');

        return $this->jsonSuccess('Base', compact('anos'));
    }

    /**
     * Esta função retorna todos os dados do relatório para a tela de relatórios 
     * com base nos critérios definidos pelo usuário na tela de Relatório.
     * 
     * @param void
     * 
     * @return json O resultado da operação
     */
    public function geraRelatorio()
    {
        $tabelaExame = 'exame_fisico_geral';
        $tabelaEvolucao = 'evolucao_pacientes';
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

        $relatorioAnual         = [];
        $relatorioBimestral     = [];
        $atendimentoEnfermagem  = [];
        $atendimentoConsultas   = [];

        foreach ($criterios['ano_atendimento'] as $key => $ano) {
            foreach ($meses as $numMes => $mes) {
                foreach ($criterios['tipo_atendimento'] as $atendimento) {
                    if ($atendimento == 'Enfermagem') {
                        $atendimentoEnfermagem [$mes] ['mes'] = $mes;
                        $atendimentoEnfermagem [$mes] = $this->getAtendimentoData($ano, $numMes, $tabelaExame);
                    }

                    if ($atendimento == 'Consulta') {
                        $atendimentoConsultas [$mes]['mes'] = $mes;
                        $atendimentoConsultas [$mes] = $this->getAtendimentoData($ano, $numMes, $tabelaEvolucao);
                    }
                }
            }

            if (isset($atendimentoEnfermagem)) {
                $relatorioAnual [] = $atendimentoEnfermagem;
            }
            if (isset($atendimentoConsultas)) {
                $relatorioAnual [] = $atendimentoConsultas;
            }
        }

        $relatorioAnual = $this->trabalhaRelatorioAnual($relatorioAnual, $meses);
        $relatorioBimestral = $this->trabalhaRelatorioBimestral($relatorioAnual, $meses);

        return $this->jsonSuccess('Gráficos', compact(['relatorioAnual','relatorioBimestral']));
    }

    /**
     * Retorna a quantidade de atendimentos de algum mês em algum ano
     *
     * @param int $ano O ano
     * @param int $numMes O número do mês
     * @param string $tabela A tabela que será buscada as informações
     *
     * @return array O array com todas os quantitativos de algum mês em algum ano
     */
    public function getAtendimentoData($ano, $numMes, $tabela)
    {
        // Tipos de atendimento
        $atendimentos ['funcionario']      = $this->getLineTableCount($tabela, $ano, $numMes, 'Funcionário');
        $atendimentos ['aluno']            = $this->getLineTableCount($tabela, $ano, $numMes, 'Aluno');
        $atendimentos ['dependente']       = $this->getLineTableCount($tabela, $ano, $numMes, 'Dependente');
        $atendimentos ['comunidade']       = $this->getLineTableCount($tabela, $ano, $numMes, 'Comunidade');
        $atendimentos ['servico_prestado'] = $this->getLineTableCount($tabela, $ano, $numMes, 'Serviço Prestado');

        // Soma
        $atendimentos ['soma'] =
          $atendimentos ['funcionario']
        + $atendimentos ['aluno']
        + $atendimentos ['dependente']
        + $atendimentos ['comunidade']
        + $atendimentos ['servico_prestado'];

        return $atendimentos;
    }

    /**
     * Retorna a quantidade de linha em alguma tabela com base no mês e ano e critério
     *
     * @param int $ano O ano
     * @param int $mes O mês
     * @param string $criterio o tipo de paciente
     *
     * @return array A quantidade de linhas
     */
    public function getLineTableCount($tabela, $ano, $mes, $criterio)
    {
        return DB::table($tabela)
            ->join('pacientes', $tabela.'.paciente_id', '=', 'pacientes.id')
            ->where('pacientes.tipo', $criterio)
            ->whereRaw("DATE_FORMAT(data, '%m') = ".$mes)
            ->whereRaw("DATE_FORMAT(data, '%Y') = ".$ano)
            ->count();
    }

    /**
     * Trata os dados que serão transformados no relatório anual
     *
     * @param array $relatorioAnual Os dados brutos do relatório
     * @param array $meses Todos os meses do ano
     *
     * @return array O relatório com os dados organizados e prontos para
     * serem enviados à tela de relatório
     */
    public function trabalhaRelatorioAnual($relatorioAnual, $meses)
    {
        // Gera um array igual ao $relatorioAnual com valores zerados para o calculo a seguir
        foreach ($meses as $numMes => $mes) {
            $relatorioAnualTrabalhado[$mes]['funcionario']      = 0;
            $relatorioAnualTrabalhado[$mes]['aluno']            = 0;
            $relatorioAnualTrabalhado[$mes]['dependente']       = 0;
            $relatorioAnualTrabalhado[$mes]['comunidade']       = 0;
            $relatorioAnualTrabalhado[$mes]['servico_prestado'] = 0;
            $relatorioAnualTrabalhado[$mes]['soma']             = 0;
        }
        // Soma o quantitativo dos meses de todos os anos
        foreach ($relatorioAnual as $key => $relatorio) {
            foreach ($relatorio as $mes => $dados) {
                $relatorioAnualTrabalhado[$mes]['mes']               = $mes;
                $relatorioAnualTrabalhado[$mes]['funcionario']      += $dados['funcionario'];
                $relatorioAnualTrabalhado[$mes]['aluno']            += $dados['aluno'];
                $relatorioAnualTrabalhado[$mes]['dependente']       += $dados['dependente'];
                $relatorioAnualTrabalhado[$mes]['comunidade']       += $dados['comunidade'];
                $relatorioAnualTrabalhado[$mes]['servico_prestado'] += $dados['servico_prestado'];
                $relatorioAnualTrabalhado[$mes]['soma']             += $dados['soma'];
            }
        }

        return $relatorioAnualTrabalhado;
    }

    /**
     * Trata os dados que serão transformados no relatório bimestral
     *
     * @param array $relatorioAnual Os dados brutos do relatório
     * @param array $meses Todos os meses do ano
     *
     * @return array O relatório com os dados organizados e prontos para
     * serem enviados à tela de relatório
     */
    public function trabalhaRelatorioBimestral($relatorioAnual, $meses)
    {
        // Gera um array com valores zerados para o calculo a seguir
        $bimestre = 1;
        $relatorio = [];
        foreach ($meses as $numMes => $mes) {
            $relatorio[$numMes]= $relatorioAnual[$mes]; //Substitui a chave de $relatorioAnual do tipo string para int
            if ($numMes%2 == 0) {
                $relatorioBimestralTrabalhado[$bimestre]['bimestre']         = $bimestre;
                $relatorioBimestralTrabalhado[$bimestre]['funcionario']      = 0;
                $relatorioBimestralTrabalhado[$bimestre]['aluno']            = 0;
                $relatorioBimestralTrabalhado[$bimestre]['dependente']       = 0;
                $relatorioBimestralTrabalhado[$bimestre]['comunidade']       = 0;
                $relatorioBimestralTrabalhado[$bimestre]['servico_prestado'] = 0;
                $relatorioBimestralTrabalhado[$bimestre]['soma']             = 0;
                $bimestre++;
            }
        }

        $relatorioAnual = $relatorio;
        $index = 1;
        // Probably I'm doing this for dumb way, but works
        foreach ($relatorioBimestralTrabalhado as $key => $relatorio) {
            $relatorioBimestralTrabalhado[$key]['funcionario']      = $relatorioAnual[$index]['funcionario'] + $relatorioAnual[$index+1]['funcionario'];
            $relatorioBimestralTrabalhado[$key]['aluno']            = $relatorioAnual[$index]['aluno'] + $relatorioAnual[$index+1]['aluno'];
            $relatorioBimestralTrabalhado[$key]['dependente']       = $relatorioAnual[$index]['dependente'] + $relatorioAnual[$index+1]['dependente'];
            $relatorioBimestralTrabalhado[$key]['comunidade']       = $relatorioAnual[$index]['comunidade'] + $relatorioAnual[$index+1]['comunidade'];
            $relatorioBimestralTrabalhado[$key]['servico_prestado'] = $relatorioAnual[$index]['servico_prestado'] + $relatorioAnual[$index+1]['servico_prestado'];
            $relatorioBimestralTrabalhado[$key]['soma']             = $relatorioAnual[$index]['soma'] + $relatorioAnual[$index+1]['soma'];
            $index +=2;
        }
        return $relatorioBimestralTrabalhado;
    }
}
