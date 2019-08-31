import { Component, OnInit } from '@angular/core';
import { PacienteService } from './paciente.service';
import { Paciente } from './paciente';

@Component({
    selector: 'paciente-cmp',
    moduleId: module.id,
    templateUrl: 'paciente.component.html'
})

export class PacienteComponent implements OnInit{
    pacientes: Paciente[];
    constructor(private pacienteService: PacienteService) { }
    ngOnInit(){
        this.getPacientes();
    }

    getPacientes(): void {
        this.pacienteService.getPacientes()
        .subscribe(pacientes => this.pacientes = pacientes);
        console.log(this.pacientes);
    }
}
