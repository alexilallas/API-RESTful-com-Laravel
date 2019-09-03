import { Component, OnInit } from '@angular/core';
import { BaseFormFieldsService } from '../form/base-form-fields.service';
import { Paciente } from './paciente';
// import { PacienteService } from './paciente.service';
// import { FormGroup, FormControl } from '@angular/forms';

@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent implements OnInit{
    public _sexo: any [] = []
    public _estado_civil: any [] = []
    public _tipo_paciente : any [] = []
    public submitted:boolean = false

    public form = new  Paciente()
    
    constructor
    (
        private formService: BaseFormFieldsService, 
        
        // private pacienteService:PacienteService
    ) { }

    ngOnInit(){
        this.getFormFields()
    }
    

    onSubmit() {
        this.submitted = true
        console.log(this.form)
    }

    getFormFields(): void {
        this.formService.getFields()
        .subscribe(response => {
            this._sexo = response['data']['result']['sexo'],
            this._estado_civil = response['data']['result']['estado_civil'],
            this._tipo_paciente = response['data']['result']['tipo_paciente']
        })
    }

    // getPacientes(): void{
    //     this.pacienteService.getPacientes()
    //     .subscribe(response => this.pacientes = response)
    // }
}
