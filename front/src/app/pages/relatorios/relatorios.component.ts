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
  public _tipo_relatorio: any;

  public form: any = new Relatorio();
  public relatorioAnual: any = [];
  public showRelatorioAnual: boolean = false;
  public totalAnual: number;
  public relatorioBimestral: any = [];
  public showRelatorioBimestral: boolean = false;
  public totalBimestral: number;

  constructor(
    public relatorioService: RelatorioService,
  ) {
  }

  ngOnInit() {
    this.getBase()
    this._tipo_atendimento = ['Consulta', 'Enfermagem']
    this._tipo_relatorio = ['Bimestral', 'Trimestral', 'Semestral', 'Anual']
  }

  getBase() {
    this.relatorioService.getBase()
      .subscribe(response => {
        this._ano_atendimento = response
      })
  }

  geraRelatorio() {

    this.showRelatorios()
    this.removeEmpty()

    if (this.form.tipo_atendimento && this.form.ano_atendimento) {
      this.relatorioService.getRelatorioData(this.form)
        .subscribe(response => {
          this.relatorioAnual = Object.values(response.data.relatorioAnual)
          this.relatorioBimestral = response.relatorioBimestral
          this.totalAnual = this.relatorioAnual.reduce((currentTotal, item) => {
            return item.soma + currentTotal
          }, 0)
        })
    }
  }

  showRelatorios() {
    if (this.form.tipo_relatorio.find(relatorio => { return relatorio == 'Anual' })) {
      this.showRelatorioAnual = true
    } else {
      this.showRelatorioAnual = false
    }

    if (this.form.tipo_relatorio.find(relatorio => { return relatorio == 'Bimestral' })) {
      this.showRelatorioBimestral = true
    } else {
      this.showRelatorioBimestral = false
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


}
