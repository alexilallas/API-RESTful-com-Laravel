import { Component, OnInit } from '@angular/core';
import { formatDate } from '@angular/common';

import { ExameFisico } from './exame-fisico';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { ExameFisicoService } from './exame-fisico.service';
import { environment } from '../../../environments/environment';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'exame-fisico-cmp',
  moduleId: module.id,
  templateUrl: 'exame-fisico.component.html'
})

export class ExameFisicoComponent extends DatatablesComponent implements OnInit {

  public _data_exames: any;

  public form: any = new ExameFisico();
  public modal = 'exameFisicoModal';
  public pacientes: any[];
  public isNewExame: boolean = true;

  constructor
    (
      public ngxSmartModalService: NgxSmartModalService,
      private exameFisicoService: ExameFisicoService
    ) {
    super();
    console.log('ExameFisicoComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.dtOptions.order = [0, 'asc']
    this.getPacientes()
  }

  getPacientes() {
    this.exameFisicoService.getPacientes()
      .subscribe(response => {
        this.pacientes = response
        this.rerenderTable()
      })
  }

  save() {
    this.saveExameFisico()
    ExameFisicoService.exameFisicoCreatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getPacientes()
        this.close()
        ExameFisicoService.exameFisicoCreatedAlert.isStopped = true
      }
    )
  }

  saveExameFisico() {
    this.exameFisicoService.postExame(this.form)
  }

  openFormEdit(id: number, nome: string) {
    this.isNewExame = false
    this.exameFisicoService.getPacienteById(id)
      .subscribe(response => {
        this._data_exames = this.getDates(response)
        this.form = response[0]
        this.form.nome = nome
        this.form.data_exame = this.form.data
      })
    this.ngxSmartModalService.open(this.modal)
  }

  update() {
    this.updateHistoricoMedico()
    ExameFisicoService.exameFisicoUpdatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getPacientes()
        this.close()
        ExameFisicoService.exameFisicoUpdatedAlert = true
      }
    )
  }

  updateHistoricoMedico() {
    this.exameFisicoService.updateExame(this.form)
  }

  close() {
    this.eraseForm()
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.form = {}
  }

  openFormNew(id: number, nome: string) {
    this.isNewExame = true
    this.form.paciente_id = id
    this.form.nome = nome
    this.getTodayDate()
    this.ngxSmartModalService.open(this.modal)
  }

  getTodayDate() {
    this.form.data = formatDate(new Date(), 'yyy-MM-dd', 'en');
  }

  getDates(dateModel: ExameFisico[]) {
    return dateModel.map(function (paciente: any) {
      return paciente.data
    })
  }

  changeDate() {
    let id = this.form.paciente_id
    let nome = this.form.nome
    this.exameFisicoService.getEvolucaoByIdAndDate(id, this.form.data_exame)
      .subscribe(response => {
        this.form = response
        this.form.nome = nome
        this.form.data_exame = this.form.data
      })
  }
}
