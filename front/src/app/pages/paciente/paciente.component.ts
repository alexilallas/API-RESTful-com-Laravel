import { Component, OnInit } from '@angular/core';
import { Paciente } from './paciente';
import { PacienteService } from './paciente.service';
import { NgxViacepService, Endereco, ErroCep } from '@brunoc/ngx-viacep';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';


@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent extends DatatablesComponent implements OnInit {
    public _sexo = ['Masculino', 'Feminino'];
    public _estado_civil = ['Solteiro(a)', 'Casado(a)', 'Viúvo(a)'];
    public _tipo_paciente = ['Aluno', 'Funcionário','Outro'];

    public form = new  Paciente();
    public modal = 'pacienteModal';
    public pacientes: any [];
    public isNewPaciente:boolean = false;

    constructor
    (
      private pacienteService:PacienteService,
      private viacep: NgxViacepService,
      public ngxSmartModalService: NgxSmartModalService
    ) {
      super();
      console.log('PacienteComponent')
    }

    ngOnInit(){
      this.getPacientes()
      this.dtOptions = environment.dtOptions
    }

    getEnderecoViaCep($event, cep): any {
      this.viacep.buscarPorCep(cep)
      .then( ( endereco: Endereco ) => {
        this.form['estado'] = endereco.uf
        this.form['cidade'] = endereco.localidade
        this.form['bairro'] = endereco.bairro
        this.form['logradouro'] = endereco.logradouro
      })
      .catch( (error: ErroCep) => {
        console.log(error.message);
      });
    }

    save(){
      console.log(this.form)
      this.savePaciente()
      PacienteService.pacienteCriado.subscribe(
        () => {
          this.form = {},
          this.getPacientes(),
          this.close()
        }
      )
    }

    close(){
      this.form = {}
      this.ngxSmartModalService.close(this.modal)
    }

    savePaciente() {
      return this.pacienteService.postPaciente(this.form)
    }

    openFormEdit(id){
      this.isNewPaciente = false
      this.form['paciente_id'] = id
      this.pacienteService.getPacienteById(id)
      .subscribe(response => {
        console.log(response)
        this.form = response
      })
      this.ngxSmartModalService.open(this.modal)
    }

    getPacientes(): any {
      this.pacienteService.getPacientes()
      .subscribe(response => {
        console.log(response)
        this.pacientes = response,
        this.rerenderTable()
      })
    }

    eraseForm(){
      this.form = {}
    }
}
