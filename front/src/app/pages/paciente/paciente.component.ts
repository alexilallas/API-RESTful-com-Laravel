import { Component, OnInit } from '@angular/core';
import { BaseFormFields } from '../form/baseform-fields';
import { BaseFormFieldsService } from '../form/base-form-fields.service';
import { Paciente } from './paciente';
import { PacienteService } from './paciente.service';

@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent implements OnInit{
    public baseFields: any []
    public pacientes: Paciente[]
    // estadoCivil:any = [ 'Solteiro(a)', 'Casado(a)', 'Viúvo(a)' ]
    // tipoSexo:any =  [ 'Masculino', 'Feminino' ]
    // tipoPaciente:any =  [ 'Aluno', 'Funcionário', 'Outro' ]
    submitted:boolean = false
    form = new Paciente()

    constructor
    (
        private baseFieldsService: BaseFormFieldsService, 
        private pacienteService:PacienteService
    ) { }

    ngOnInit(){
        this.getFormFields()
        this.getPacientes()
    }
    

    onSubmit() {
        this.submitted = true
        console.log(this.form)
        //alert(JSON.stringify(this.form))
    }

    getFormFields(): void {
        this.baseFieldsService.getFields()
        .subscribe(data => this.baseFields = data)
    }

    getPacientes(): void{
        this.pacienteService.getPacientes()
        .subscribe(response => this.pacientes = response)
    }
}
