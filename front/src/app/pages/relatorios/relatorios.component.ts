import { Component, OnInit } from '@angular/core';

import { RelatorioService } from './relatorios.service';
import { Relatorio } from './relatorio';

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

    if (this.form.tipo_atendimento && this.form.ano_atendimento) {
      this.relatorioService.getRelatorioData(this.form)
        .subscribe(response => {
          this.relatorioAnual = Object.values(response.data.frequenciaAtendimentoEnfermagem)
          this.relatorioBimestral = response.relatorioBimestral
          this.totalAnual = this.relatorioAnual.reduce((currentTotal, item) =>{
            return item.soma + currentTotal
          },0)
        })
    }
  }


}
