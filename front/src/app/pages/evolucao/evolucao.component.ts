import { Component, OnInit } from '@angular/core';
import { formatDate } from '@angular/common';

import { Evolucao } from './evolucao';
import { EvolucaoService } from './evolucao.service';
import { InventarioService } from '../inventario/inventario.service';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { environment } from '../../../environments/environment';
import { faPills, IconDefinition } from '@fortawesome/free-solid-svg-icons';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'app-evolucao',
  templateUrl: './evolucao.component.html',
  styleUrls: ['./evolucao.component.scss']
})
export class EvolucaoComponent extends DatatablesComponent implements OnInit {

  public _data_evolucoes: any;
  public _medicamentos: any = [];
  public faPills: IconDefinition = faPills;
  public medicamentosEvolucao: any = [];

  public form: any = new Evolucao();
  public modal = 'evolucaoModal';
  public pacientes: any[];
  public isNewEvolucao: boolean = true;

  constructor
    (
      public ngxSmartModalService: NgxSmartModalService,
      private evolucaoService: EvolucaoService,
      private inventarioService: InventarioService,
  ) {
    super();
    console.log('EvolucaoComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.dtOptions.order = [0, 'asc']
    this.getPacientes()
    this.inventarioService.getItens()
      .subscribe(response => {
        this._medicamentos = response
      })
  }

  getPacientes() {
    this.evolucaoService.getPacientes()
      .subscribe(response => {
        this.pacientes = response
        this.rerenderTable()
      })
  }

  save() {
    this.saveEvolucao()
    EvolucaoService.evolucaoCreatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getPacientes()
        this.close()
        EvolucaoService.evolucaoCreatedAlert.isStopped = true
      }
    )
  }

  saveEvolucao() {
    this.evolucaoService.postEvolucao(this.form)
  }

  openFormEdit(id: number, nome: string) {
    this.isNewEvolucao = false
    this.evolucaoService.getPacienteById(id)
      .subscribe(response => {
        this._data_evolucoes = this.formatDate(response)
        this.form = response[0]
        this.form.nome = nome
        this.form.data_evolucao = EvolucaoComponent.formatSingleDate(this.form.data)
      })
    this.ngxSmartModalService.open(this.modal)
  }

  update() {
    this.updateEvolucao()
    EvolucaoService.evolucaoUpdatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getPacientes()
        this.close()
        EvolucaoService.evolucaoUpdatedAlert = true
      }
    )
  }

  updateEvolucao() {
    this.evolucaoService.updateEvolucao(this.form)
  }

  close() {
    this.eraseForm()
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.form = {}
  }

  openFormNew(id: number, nome: string) {
    this.isNewEvolucao = true
    this.form.paciente_id = id
    this.form.nome = nome
    this.getTodayDate()
    this.ngxSmartModalService.open(this.modal)
  }

  getTodayDate() {
    this.form.data = formatDate(new Date(), 'yyy-MM-dd', 'en');
  }

  formatDate(dateModel: Evolucao[]) {
    return dateModel.map(function (paciente: any) {
      return EvolucaoComponent.formatSingleDate(paciente.data)
    })
  }

  static formatSingleDate(dateModel: Date) {
    let date: Date = dateModel
    return formatDate(date, 'dd/MM/yyyy', 'en')
  }

  filterPacienteByDate(Pacientes: any[]) {
    let dateCompare = this.form.data_evolucao
    let examePaciente = Pacientes.map(function (paciente) {
      if (dateCompare == EvolucaoComponent.formatSingleDate(paciente.data)) {
        return paciente
      }
    })
    this.form = examePaciente.filter(Boolean)[0]
    this.form.data_evolucao = EvolucaoComponent.formatSingleDate(this.form.data)
  }

  changeDate() {
    let id = this.form.paciente_id
    let nome = this.form.nome
    this.evolucaoService.getPacienteById(id)
      .subscribe(response => {
        this.filterPacienteByDate(response)
        this.form.nome = nome
      })
  }

  adicionaMedicamento() {
    
    this.medicamentosEvolucao.push(
      {
        'nome': this.form.medicamento,
        'quantidade': this.form.quantidade
      })

    console.log(this.medicamentosEvolucao)
  }

}
