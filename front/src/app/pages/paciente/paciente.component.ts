import { Component, OnInit } from '@angular/core';
import { BaseFormFieldsService } from '../form/base-form-fields.service';
// import { Paciente } from './paciente';
// import { PacienteService } from './paciente.service';
import { FormGroup, FormControl } from '@angular/forms';

@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent implements OnInit{
    public baseFields: any []
    public fieldSexo: []
    // public pacientes: Paciente[]
    submitted:boolean = false
    form = new FormGroup({
        nome: new FormControl(''),
        cpf_rg: new FormControl(''),
        estado_civil: new FormControl(''),
    })
    
    constructor
    (
        private baseFieldsService: BaseFormFieldsService, 
        // private pacienteService:PacienteService
    ) { }

    ngOnInit(){
        this.getFormFields()
        // this.getPacientes()
        this.fieldSexo =  this.baseFields['data']['result']['sexo']
        console.log(this.fieldSexo)
    }
    

    onSubmit() {
        this.submitted = true
        console.log(this.form)
        //alert(JSON.stringify(this.form))
    }

    getFormFields(): void {
        this.baseFieldsService.getFields()
        .subscribe(response => this.baseFields = response)
    }

    // getPacientes(): void{
    //     this.pacienteService.getPacientes()
    //     .subscribe(response => this.pacientes = response)
    // }
}
