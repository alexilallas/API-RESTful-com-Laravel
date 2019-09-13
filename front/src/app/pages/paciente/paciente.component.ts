import { Component, OnDestroy, OnInit } from '@angular/core';
import { BaseFormFieldsService } from '../form/base-form-fields.service';
import { Paciente } from './paciente';
import { PacienteService } from './paciente.service';
import { NgxViacepService, Endereco, ErroCep } from '@brunoc/ngx-viacep';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { ThrowStmt } from '@angular/compiler';
import { Subject } from 'rxjs';

@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent implements OnDestroy, OnInit{
    public _sexo: any [] = []
    public _estado_civil: any [] = []
    public _tipo_paciente : any [] = []
    
    public form = new  Paciente()
    public pacientes: any []
    private dtOptions: DataTables.Settings = {};
    dtTrigger: Subject = new Subject();

    constructor
    (
        private formService: BaseFormFieldsService, 
        private pacienteService:PacienteService,
        private viacep: NgxViacepService,
        public ngxSmartModalService: NgxSmartModalService,
    ) { }

    ngOnInit(){
        this.getBaseFields()
        this.getPacientes()
        this.dtOptions = environment.dtOptions
    }

    ngOnDestroy(): void {
        this.dtTrigger.unsubscribe();
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
        this.form = null
    }

    getBaseFields(): void {
        this.formService.getFields()
        .subscribe(response => {
            this._sexo = response['sexo'],
            this._estado_civil = response['estado_civil'],
            this._tipo_paciente = response['tipo_paciente']
        })
    }

    getPacientes(): any {
        this.pacienteService.getPacientes()
        .subscribe(response => { 
            console.log(response), 
            this.pacientes = response['data']['pacientes'], 
            this.dtTrigger.next()
        })
    }
}
