import { Component, OnInit } from '@angular/core';
import { BaseFormFieldsService } from '../form/base-form-fields.service';
import { Paciente } from './paciente';
import { PacienteService } from './paciente.service';

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
    
    constructor
    (
        private formService: BaseFormFieldsService, 
        private pacienteService:PacienteService
    ) { }

    ngOnInit(){
        this.getFormFields()
    }
    

    onSubmit() {
        console.log(this.form)
    }

    postPaciente(paciente: Paciente):void{
        this.pacienteService.postPaciente(paciente)
    }

    getFormFields(): void {
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
