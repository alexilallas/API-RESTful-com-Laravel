import { Component, OnInit } from '@angular/core';
import { FichaAnaminese } from './ficha-anaminese';
import { PacienteService } from '../paciente/paciente.service';
import { environment } from '../../../environments/environment';

@Component({
    selector: 'ficha-anaminese-cmp',
    moduleId: module.id,
    templateUrl: 'inicio.component.html'
})

export class FichaAnamineseComponent implements OnInit{

    public form = new FichaAnaminese()
    public _fator_rh = ['Positivo', 'Negativo']
    private dtOptions: DataTables.Settings = {};
    
    constructor
    (
        private pacienteService:PacienteService,
    ){}

    ngOnInit(){
        this.form['dt'] = false
        this.form['hb'] = false
        this.form['fa'] = false
        this.form['influenza'] = false
        this.form['antirrabica'] = false
        this.dtOptions = environment.dtOptions
        
    }


    onSubmit() {
        console.log(this.form)
    }
}
