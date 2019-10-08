import { Component, OnInit } from '@angular/core';

import { AreaDoPaciente } from './area-do-paciente';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { AreaDoPacienteService } from './area-do-paciente.service';

@Component({
  selector: 'app-area-do-paciente',
  templateUrl: './area-do-paciente.component.html',
  styleUrls: ['../../auth/login/login.component.scss']
})

export class AreaDoPacienteComponent implements OnInit {

  public historico: any;
  public hasHistorico: boolean = false;

  public exames: any;
  public hasExame: boolean = false;

  public evolucoes: any;
  public hasEvolucao: boolean = false;

  public form: any = new AreaDoPaciente();
  public modal: string = 'prontuarioModal';
  public loading: boolean = false;

  constructor(
    private areaDoPacienteService: AreaDoPacienteService,
    public ngxSmartModalService: NgxSmartModalService,
  ) { }

  ngOnInit() {
  }

  getDataFromPacienteArea() {
    this.loading = true
    let date = this.form.data_nascimento.split('/')
    let data_nascimento = date[2] + '-' + date[1] + '-' + date[0]
    let form: any = {
      'data_nascimento': data_nascimento,
      'cpf_rg': this.form.cpf_rg
    }
    this.areaDoPacienteService.getProntuario(form)
      .subscribe(
        (response) => {
          this.loading = false
          if (response === undefined) {
            return
          }
          this.form = response.paciente
          if (response.historico) {
            this.historico = response.historico
            this.hasHistorico = true
          } else {
            this.hasHistorico = false
          }
          if (response.exames.length > 0) {
            this.exames = response.exames
            this.hasExame = true
          } else {
            this.hasExame = false
          }
          if (response.evolucoes.length > 0) {
            this.evolucoes = response.evolucoes
            this.hasEvolucao = true
          } else {
            this.hasEvolucao = false
          }
          this.form.nome_contato = response.paciente.nome_contato
          this.form.numero_contato = response.paciente.numero_contato
          if (response.status == 200) {
            this.ngxSmartModalService.open(this.modal)
          }
          this.ngxSmartModalService.open(this.modal)
          this.form.data_nascimento = date
        }
      )
  }

  close() {
    this.exames = null
    this.evolucoes = null
    this.ngxSmartModalService.close(this.modal)
  }

}
