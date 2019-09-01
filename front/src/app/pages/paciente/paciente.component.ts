import { Component, OnInit } from '@angular/core';
import { PacienteService } from './paciente.service';
import { Paciente } from './paciente';

@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent implements OnInit{
    public pacientes: Paciente[]
    estadoCivil:any = [ 'Solteiro(a)', 'Casado(a)', 'Viúvo(a)' ]
    tipoSexo:any =  [ 'Masculino', 'Feminino' ]
    tipoPaciente:any =  [ 'Aluno', 'Funcionário', 'Outro' ]
    submitted:boolean = false
    form = new Paciente()

    constructor(private pacienteService: PacienteService) { }

    ngOnInit(){
        this.getPacientes();
    }
    

    onSubmit() {
        this.submitted = true;
        console.log(this.form);
        //alert(JSON.stringify(this.form))
    }

  
    getPacientes(): void {
        this.pacienteService.getPacientes()
        .subscribe(pacientes => this.pacientes = pacientes);
    }
}
