import { Component, OnInit } from '@angular/core';

import { InicioService } from './inicio.service';
import Chart from 'chart.js';

@Component({
  selector: 'inicio-cmp',
  moduleId: module.id,
  templateUrl: 'inicio.component.html'
})

export class InicioComponent implements OnInit {

  public usuarios: number;
  public pacientes: number;
  public inventario: number;
  public atendimentos: number;

  public atendimentoEnfermagem: number;
  public atendimentoConsultas: number;
  public totalAtendimentos: number;

  public frequenciaAtendimentoEnfermagem: any;
  public frequenciaAtendimentoConsultas: any;

  public currentDate: Date = new Date();
  public _ano_referencia: any = [];

  public form: any = new Array;

  public canvas: any;
  public ctx;
  public chartColor;
  public chartQuantidadeAtendimento;
  public chartFrequenciaAtendimento;

  ngOnInit() {
    this.getDashboardData()
    this.form.ano = this.currentDate.getFullYear()
  }

  constructor(
    public inicioService: InicioService
  ) {
    console.log('InicioComponent')
  }

  getDashboardData() {
    this.inicioService.getDashboardData()
      .subscribe(response => {
        this._ano_referencia = response.anos
        this.usuarios = response.usuarios
        this.pacientes = response.pacientes
        this.inventario = response.inventario
        this.atendimentos = response.atendimentos
        this.atendimentoEnfermagem = response.atendimentoEnfermagem
        this.atendimentoConsultas = response.atendimentoConsultas
        this.totalAtendimentos = this.atendimentoEnfermagem + this.atendimentoConsultas
        this.frequenciaAtendimentoEnfermagem = response.frequenciaAtendimentoEnfermagem
        this.frequenciaAtendimentoConsultas = response.frequenciaAtendimentoConsultas
        this.frequenciaAtendimentoChart()
        this.quantidadeAtendimentoChart()
      })
  }

  frequenciaAtendimentoChart() {
    this.chartColor = "#FFFFFF"
    this.canvas = document.getElementById("frequenciaAtendimento")
    this.ctx = this.canvas.getContext("2d")

    this.chartFrequenciaAtendimento = new Chart(this.ctx, {
      type: 'line',

      data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        datasets: [{
          label: 'Atendimento Médico',
          borderColor: "#00bcd4",
          backgroundColor: "#00bcd4",
          pointRadius: 0,
          pointHoverRadius: 0,
          borderWidth: 3,
          data: this.frequenciaAtendimentoConsultas
        },
        {
          label: 'Exame Físico',
          borderColor: "#fcc468",
          backgroundColor: "#fcc468",
          pointRadius: 0,
          pointHoverRadius: 0,
          borderWidth: 3,
          data: this.frequenciaAtendimentoEnfermagem
        }
        ]
      },
      options: {
        legend: {
          display: false
        },

        tooltips: {
          enabled: false
        },

        scales: {
          yAxes: [{

            ticks: {
              fontColor: "#9f9f9f",
              beginAtZero: false,
              maxTicksLimit: 5,
            },
            gridLines: {
              drawBorder: false,
              zeroLineColor: "#ccc",
              color: 'rgba(255,255,255,0.05)'
            }

          }],

          xAxes: [{
            barPercentage: 1.6,
            gridLines: {
              drawBorder: false,
              color: 'rgba(255,255,255,0.1)',
              zeroLineColor: "transparent",
              display: false,
            },
            ticks: {
              padding: 20,
              fontColor: "#9f9f9f"
            }
          }]
        },
      }
    });
  }

  quantidadeAtendimentoChart() {
    this.canvas = document.getElementById("quantidadeAtendimento");
    this.ctx = this.canvas.getContext("2d");
    this.chartQuantidadeAtendimento = new Chart(this.ctx, {
      type: 'pie',
      data: {
        labels: ['Enfermagem', 'Consultas'],
        datasets: [{
          label: "Atendimentos",
          pointRadius: 0,
          pointHoverRadius: 0,
          backgroundColor: [
            '#fcc468',
            '#00bcd4'
          ],
          borderWidth: 0,
          data: [this.atendimentoEnfermagem, this.atendimentoConsultas]
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

  getChartByAno() {
    this.inicioService.getChartByAno(this.form.ano)
      .subscribe(response => {
        this.atendimentoEnfermagem = response.atendimentoEnfermagem
        this.atendimentoConsultas = response.atendimentoConsultas
        this.totalAtendimentos = this.atendimentoEnfermagem + this.atendimentoConsultas
        this.frequenciaAtendimentoEnfermagem = response.frequenciaAtendimentoEnfermagem
        this.frequenciaAtendimentoConsultas = response.frequenciaAtendimentoConsultas
        this.frequenciaAtendimentoChart()
        this.quantidadeAtendimentoChart()
      })
  }
}
