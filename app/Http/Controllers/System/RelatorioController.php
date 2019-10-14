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
        
        return $this->jsonSuccess('Gráficos', compact(['relatorioAnual']));
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
}
