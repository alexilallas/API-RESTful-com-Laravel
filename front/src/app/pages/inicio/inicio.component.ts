import { Component, OnInit } from '@angular/core';

import { InicioService } from './inicio.service';
import Chart from 'chart.js';


@Component({
    selector: 'inicio-cmp',
    moduleId: module.id,
    templateUrl: 'inicio.component.html'
})

export class InicioComponent implements OnInit{

  public usuarios: number;
  public pacientes: number;
  public inventario: number;
  public atendimentos: number;

  public canvas : any;
  public ctx;
  public chartColor;
  public chartEmail;
  public chartHours;

    ngOnInit(){

      this.frequenciaAtendimentoChart()
      this.getDashboardData()

      this.quantidadeAtendimentoChart()

      // var speedCanvas = document.getElementById("speedChart");

      // var dataFirst = {
      //   data: [0, 19, 15, 20, 30, 40, 40, 50, 25, 30, 50, 70],
      //   fill: false,
      //   borderColor: '#fbc658',
      //   backgroundColor: 'transparent',
      //   pointBorderColor: '#fbc658',
      //   pointRadius: 4,
      //   pointHoverRadius: 4,
      //   pointBorderWidth: 8,
      // };

      // var dataSecond = {
      //   data: [0, 5, 10, 12, 20, 27, 30, 34, 42, 45, 55, 63],
      //   fill: false,
      //   borderColor: '#51CACF',
      //   backgroundColor: 'transparent',
      //   pointBorderColor: '#51CACF',
      //   pointRadius: 4,
      //   pointHoverRadius: 4,
      //   pointBorderWidth: 8
      // };

      // var speedData = {
      //   labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      //   datasets: [dataFirst, dataSecond]
      // };

      // var chartOptions = {
      //   legend: {
      //     display: false,
      //     position: 'top'
      //   }
      // };

      // var lineChart = new Chart(speedCanvas, {
      //   type: 'line',
      //   hover: false,
      //   data: speedData,
      //   options: chartOptions
      // });
    }

    constructor(
      public inicioService: InicioService
    ){
      console.log('InicioComponent')
    }

    getDashboardData() {
      this.inicioService.getDashboardData()
      .subscribe(response => {
        this.usuarios = response.usuarios
        this.pacientes = response.pacientes
        this.inventario = response.inventario
        this.atendimentos = response.atendimentos
      })
    }

    frequenciaAtendimentoChart(){
      this.chartColor = "#FFFFFF"
      this.canvas = document.getElementById("frequenciaAtendimento")
      this.ctx = this.canvas.getContext("2d")

      this.chartHours = new Chart(this.ctx, {
        type: 'line',

        data: {
          labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out"],
          datasets: [{
              label: 'Atendimento Médico',
              borderColor: "#00bcd4",
              backgroundColor: "#00bcd4",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              data: [15, 12, 12, 13, 15, 20, 14, 18, 20, 17]
            },
            {
              label: 'Exame Físico',
              borderColor: "#fcc468",
              backgroundColor: "#fcc468",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              data: [18, 15, 17, 15, 16, 21, 15, 19, 21, 25]
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

    quantidadeAtendimentoChart(){
      this.canvas = document.getElementById("chartEmail");
      this.ctx = this.canvas.getContext("2d");
      this.chartEmail = new Chart(this.ctx, {
        type: 'pie',
        data: {
          labels: [18, 13],
          datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: [
              '#fcc468',
              '#00bcd4'
            ],
            borderWidth: 0,
            data: [18, 13]
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
            enabled: false
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
}
