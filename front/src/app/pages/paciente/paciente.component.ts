import { Component, OnInit } from '@angular/core';
import { BaseFormFieldsService } from '../form/base-form-fields.service';
import { Paciente } from './paciente';
import { PacienteService } from './paciente.service';
import { NgxViacepService, Endereco, ErroCep } from '@brunoc/ngx-viacep';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';

@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent implements OnInit{
    public _sexo: any [] = []
    public _estado_civil: any [] = []
    public _tipo_paciente : any [] = []
    
    public form = new  Paciente()
    private dtOptions: DataTables.Settings = {};
    
    constructor
    (
        private formService: BaseFormFieldsService, 
        private pacienteService:PacienteService,
        private viacep: NgxViacepService,
        public ngxSmartModalService: NgxSmartModalService,
    ) { }

    ngOnInit(){
        this.getBaseFields()
        this.dtOptions = environment.dtOptions
    }

    onSubmit() {
        console.log(this.form)
    }

    getEnderecoViaCep($event, cep): any {
        this.viacep.buscarPorCep(cep).then( ( endereco: Endereco ) => {
        console.log(endereco);
        this.form['estado'] = endereco.uf
        this.form['cidade'] = endereco.localidade
        this.form['bairro'] = endereco.bairro
        this.form['logradouro'] = endereco.logradouro
        }).catch( (error: ErroCep) => {
        console.log(error.message);
        });
    }

    postPaciente(paciente: Paciente):void{
        this.pacienteService.postPaciente(paciente)
    }

    getBaseFields(): void {
        this.formService.getFields()
        .subscribe(response => {
            this._sexo = response['sexo'],
            this._estado_civil = response['estado_civil'],
            this._tipo_paciente = response['tipo_paciente']
        })
    }

    // getPacientes(): void{
    //     this.pacienteService.getPacientes()
    //     .subscribe(response => this.pacientes = response)
    // }
}
