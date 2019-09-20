import { Component, OnInit } from '@angular/core';
import { ExameFisico } from './exame-fisico';
import { ExameFisicoService } from './exame-fisico.service';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'exame-fisico-cmp',
  moduleId: module.id,
  templateUrl: 'exame-fisico.component.html'
})

export class ExameFisicoComponent extends DatatablesComponent implements OnInit {

  public form = new ExameFisico();
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
    this.getPacientes()
    this.getTodayDate()
  }

  getPacientes(): any {
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

  openFormEdit(id) {
    this.isNewExame = false
    this.form['paciente_id'] = id
    this.exameFisicoService.getPacienteById(id)
      .subscribe(response => {
        console.log(response)
        this.form = response
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

  openFormNew(id, nome) {
    this.isNewExame = true
    this.form['paciente_id'] = id
    this.form['nome'] = nome
    this.ngxSmartModalService.open(this.modal)
  }

  getTodayDate() {
    let date: Date = new Date();
    date.setUTCDate(-3)
    console.log(date.getDate())
    date.toLocaleTimeString()
    let dia = date.getDay();
    let mes = date.getMonth();
    let ano = date.getFullYear();
    this.form['data'] = date// dia + '/' + mes + '/' + ano
    console.log(this.form['data'])
  }
}
