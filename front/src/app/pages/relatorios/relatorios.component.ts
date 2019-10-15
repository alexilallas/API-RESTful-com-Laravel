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
  public totalAnual: number;
  public relatorioBimestral: any = [];
  public totalBimestral: number;

  public canvas: any;
  public ctx;
  public chartColor;
  public chartRelatorioAnual;
  public chartRelatorioBimestral;

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
          this.totalAnual = this.relatorioAnual.reduce((currentTotal, item) => {
            return item.soma + currentTotal
          }, 0)
          this.totalBimestral = this.relatorioBimestral.reduce((currentTotal, item) => {
            return item.soma + currentTotal
          }, 0)
          this.relatorioAnualChart()
        })
    }
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

  relatorioAnualChart() {
    this.canvas = document.getElementById("relatorioAnual");
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
          data: [20, 20, 20, 20, 20]
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

}
