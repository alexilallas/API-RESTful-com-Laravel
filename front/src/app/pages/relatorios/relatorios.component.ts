import { Component, OnInit } from '@angular/core';

import { RelatorioService } from './relatorios.service';
import { Relatorio } from './relatorio';
import Chart from 'chart.js';

@Component({
  selector: 'app-relatorios',
  templateUrl: './relatorios.component.html',
  styleUrls: ['./relatorios.component.scss']
})
export class RelatorioComponent implements OnInit {

  public _tipo_atendimento: any;
  public _ano_atendimento: any;

  public form: any = new Relatorio();
  public relatorioAnual: any = [];
  public relatorioBimestral: any = [];
  public totalAtendimentos: number;

  public totalAtendimentoFuncionario: number;
  public totalAtendimentoAluno: number;
  public totalAtendimentoDependente: number;
  public totalAtendimentoServicoPrestado: number;
  public totalAtendimentoComunidade: number;
  public chartLineData: any;

  public canvas: any;
  public ctx;
  public chartColor;
  public chartRelatorioAnual;

  constructor(
    public relatorioService: RelatorioService,
  ) {
  }

  ngOnInit() {
    this.getBase()
    this._tipo_atendimento = ['Consulta', 'Enfermagem']
  }

  getBase() {
    this.relatorioService.getBase()
      .subscribe(response => {
        this._ano_atendimento = response
      })
  }

  geraRelatorio() {
    this.removeEmpty()

    if (this.form.tipo_atendimento && this.form.ano_atendimento) {
      this.relatorioService.getRelatorioData(this.form)
        .subscribe(response => {
          this.relatorioAnual = Object.values(response.data.relatorioAnual)
          this.relatorioBimestral = Object.values(response.data.relatorioBimestral)
          this.trataDadosRelatorio()
          this.relatorioAnualChartPizza()
          this.relatorioAnualChartLine()
        })
    }
  }

  trataDadosRelatorio() {
    this.totalAtendimentos = this.relatorioAnual.reduce((currentTotal, item) => {
      return item.soma + currentTotal
    }, 0)
    this.totalAtendimentoFuncionario = this.relatorioAnual.reduce((currentTotal, item) => {
      return item.funcionario + currentTotal
    }, 0)
    this.totalAtendimentoAluno = this.relatorioAnual.reduce((currentTotal, item) => {
      return item.aluno + currentTotal
    }, 0)
    this.totalAtendimentoDependente = this.relatorioAnual.reduce((currentTotal, item) => {
      return item.dependente + currentTotal
    }, 0)
    this.totalAtendimentoServicoPrestado = this.relatorioAnual.reduce((currentTotal, item) => {
      return item.servico_prestado + currentTotal
    }, 0)
    this.totalAtendimentoComunidade = this.relatorioAnual.reduce((currentTotal, item) => {
      return item.comunidade + currentTotal
    }, 0)
    this.chartLineData = this.relatorioAnual.map(dado => {
      return dado.soma
    })
  }

  removeEmpty() {
    if (this.form.tipo_atendimento) {
      if (this.form.tipo_atendimento.length == 0) {
        delete this.form.tipo_atendimento
      }
    }
    if (this.form.ano_atendimento) {
      if (this.form.ano_atendimento.length == 0) {
        delete this.form.ano_atendimento
      }
    }
  }

  relatorioAnualChartPizza() {
    this.canvas = document.getElementById("relatorioAnualPizza");
    this.ctx = this.canvas.getContext("2d");
    this.chartRelatorioAnual = new Chart(this.ctx, {
      type: 'pie',
      data: {
        labels: ['Funcionário', 'Aluno', 'Dependente', 'Serviço Prestado', 'Comunidade'],
        datasets: [{
          label: "Atendimentos",
          pointRadius: 0,
          pointHoverRadius: 0,
          backgroundColor: [
            '#fcc468',
            '#00bcd4',
            '#f17e5d',
            '#6bd098',
            '#6c757d'
          ],
          borderWidth: 0,
          data: [
            this.totalAtendimentoFuncionario, this.totalAtendimentoAluno,
            this.totalAtendimentoDependente, this.totalAtendimentoServicoPrestado,
            this.totalAtendimentoComunidade
          ]
        }]
      },

      options: {

        legend: {
          display: false
        },

        pieceLabel: {
          render: 'percentage',
          fontColor: ['white'],
          precision: 2
        },

        tooltips: {
          enabled: true
        },

        scales: {
          yAxes: [{

            ticks: {
              display: false
            },
            gridLines: {
              drawBorder: false,
              zeroLineColor: "transparent",
              color: 'rgba(255,255,255,0.05)'
            }

          }],

          xAxes: [{
            barPercentage: 1.6,
            gridLines: {
              drawBorder: false,
              color: 'rgba(255,255,255,0.1)',
              zeroLineColor: "transparent"
            },
            ticks: {
              display: false,
            }
          }]
        },
      }
    });
  }

  relatorioAnualChartLine() {
    var speedCanvas = document.getElementById("relatorioAnualLine");

    var data = {
      data: this.chartLineData,
      fill: false,
      borderColor: '#51CACF',
      backgroundColor: 'transparent',
      pointBorderColor: '#51CACF',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8,
    };

    var speedData = {
      labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
      datasets: [data]
    };

    var chartOptions = {
      legend: {
        display: false,
        position: 'top'
      }
    };

    var lineChart = new Chart(speedCanvas, {
      type: 'line',
      hover: false,
      data: speedData,
      options: chartOptions
    });
  }
}
