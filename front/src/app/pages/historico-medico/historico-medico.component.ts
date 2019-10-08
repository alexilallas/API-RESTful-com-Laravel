import { Component, OnInit } from '@angular/core';

import { HistoricoMedico } from './historico-medico';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { environment } from '../../../environments/environment';
import { HistoricoMedicoService } from './historico-medico.service';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'historico-medico-cmp',
  moduleId: module.id,
  templateUrl: 'historico-medico.component.html'
})

export class HistoricoMedicoComponent extends DatatablesComponent implements OnInit {

  public _fator_rh = ['Positivo', 'Negativo'];

  public form: any = new HistoricoMedico();
  public modal = 'historicoMedicoModal';
  public pacientes: any;
  public isNewHistorico: boolean = false;

  constructor
    (
      public ngxSmartModalService: NgxSmartModalService,
      private historicoMedicoService: HistoricoMedicoService,
  ) {
    super();
    console.log('HistoricoMedicoComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.dtOptions.order = [0, 'asc']
    this.getPacientes()
  }

  getPacientes(): any {
    this.historicoMedicoService.getPacientes()
      .subscribe(response => {
        this.pacientes = response
        this.rerenderTable()
      })
  }

  save() {
    this.saveHistoricoMedico()
    HistoricoMedicoService.historicoMedicoCreatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getPacientes()
        this.close()
        HistoricoMedicoService.historicoMedicoCreatedAlert.isStopped = true
      }
    )
  }

  saveHistoricoMedico() {
    this.historicoMedicoService.postHistorico(this.form)
  }

  openFormEdit(id, nome) {
    this.isNewHistorico = false
    this.form.paciente_id = id
    this.historicoMedicoService.getPacienteById(id)
      .subscribe(response => {
        this.form = response
        this.form.nome = nome
      })
    this.ngxSmartModalService.open(this.modal)
  }

  update() {
    this.updateHistoricoMedico()
    HistoricoMedicoService.historicoMedicoUpdatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getPacientes()
        this.close()
        HistoricoMedicoService.historicoMedicoUpdatedAlert = true
      }
    )
  }

  updateHistoricoMedico() {
    this.historicoMedicoService.updateHistorico(this.form)
  }

  close() {
    this.eraseForm()
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.form = {}
  }

  openFormNew(id, nome) {
    this.isNewHistorico = true
    this.form.paciente_id = id
    this.form.nome = nome
    this.ngxSmartModalService.open(this.modal)
  }

}
