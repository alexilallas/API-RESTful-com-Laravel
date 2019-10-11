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
    delete this.form.medicamento
    delete this.form.quantidade

    this.form.prescricao = this.medicamentosEvolucao
    this.evolucaoService.postEvolucao(this.form)
  }

  openFormEdit(id: number, nome: string) {
    this.isNewEvolucao = false
    this.evolucaoService.getPacienteById(id)
      .subscribe(response => {
        this._data_evolucoes = this.getDates(response)
        this.medicamentosEvolucao = response[0].prescricao
        this.form = response[0]
        this.form.nome = nome
        this.form.data_evolucao = this.form.data
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
    this.medicamentosEvolucao = []
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

  getDates(dateModel: Evolucao[]) {
    return dateModel.map(function (paciente: any) {
      return paciente.data
    })
  }

  changeDate() {
    let id = this.form.paciente_id
    let nome = this.form.nome
    this.evolucaoService.getEvolucaoByIdAndDate(id, this.form.data_evolucao)
      .subscribe(response => {
        this.medicamentosEvolucao = response.prescricao
        this.form = response
        this.form.nome = nome
        this.form.data_evolucao = this.form.data
      })
  }

  adicionaMedicamento() {
    let id = this.hasItem()
    if (id) {
      this.atualizaItem(id)
    } else {
      this.adicionaItem()
    }
    console.log(this.medicamentosEvolucao)
  }

  adicionaItem() {
    this.medicamentosEvolucao.push(
      {
        id: this.form.medicamento.id,
        medicamento: this.form.medicamento.nome,
        quantidade: this.form.quantidade
      })
  }

  atualizaItem(id) {
    for (let index = 0; index < this.medicamentosEvolucao.length; index++) {
      if (this.medicamentosEvolucao[index].id == id) {
        if (this.medicamentosEvolucao[index].quantidade != this.form.quantidade) {
          this.medicamentosEvolucao[index].quantidade = this.form.quantidade
        }
      }
    }
  }

  hasItem(): boolean {
    let item = this.medicamentosEvolucao.find(item => item.medicamento === this.form.medicamento.nome)
    if (item) {
      return item.id
    }
    return false
  }

}
