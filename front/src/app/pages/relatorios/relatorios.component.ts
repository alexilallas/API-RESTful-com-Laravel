import { Component, OnInit } from '@angular/core';

import { RelatoriosService } from './relatorios.service';

@Component({
  selector: 'app-relatorios',
  templateUrl: './relatorios.component.html',
  styleUrls: ['./relatorios.component.scss']
})
export class RelatorioComponent implements OnInit {

  public _tipo_atendimento: any;
  public _ano_atendimento: any;

  public form: any = new Array;
  public relatorioAnual = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
  public relatorioBimestral = ['1°', '2°', '3°', '4°', '5°', '6°']

  constructor(
    public relatoriosService: RelatoriosService,
  ) {
  }

  ngOnInit() {
    this.getBase()
    this._tipo_atendimento = ['Consulta', 'Enfermagem']
  }

  getBase() {
    this.relatoriosService.getBase()
      .subscribe(response => {
        this._ano_atendimento = response
      })
  }

  getRelatorio() {
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
    console.log(this.form)
  }


}
