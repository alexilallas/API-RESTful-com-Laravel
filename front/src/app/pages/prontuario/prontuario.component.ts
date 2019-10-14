import { Component, OnInit } from '@angular/core';
import { environment } from '../../../environments/environment';

import { Prontuario } from './prontuario';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { ProntuarioService } from './prontuario.service';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'prontuario-cmp',
  moduleId: module.id,
  templateUrl: 'prontuario.component.html',
  styleUrls: ['./prontuario.component.scss']
})

export class ProntuarioComponent extends DatatablesComponent implements OnInit {

  public historico: any;
  public hasHistorico: boolean = false;

  public exames: any;
  public hasExame: boolean = false;

  public evolucoes: any;
  public hasEvolucao: boolean = false;

  public form: any = new Prontuario();
  public modal: string = 'prontuarioModal';
  public pacientes: any[];

  constructor
    (
      public ngxSmartModalService: NgxSmartModalService,
      private prontuarioService: ProntuarioService
    ) {
    super();
    console.log('ProntuarioComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.dtOptions.order = [0, 'asc']
    this.getPacientes()
  }

  getPacientes() {
    this.prontuarioService.getPacientes()
      .subscribe(response => {
        this.pacientes = response
        this.rerenderTable()
      })
  }

  openForm(id) {
    this.prontuarioService.getPacienteById(id)
      .subscribe(response => {
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
      })
    this.ngxSmartModalService.open(this.modal)
  }

  close() {
    this.eraseForm()
    this.exames = null
    this.evolucoes = null
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.form = {}
  }

  print() {
    window.print()
  }

}
