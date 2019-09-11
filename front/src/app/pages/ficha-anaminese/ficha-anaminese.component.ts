import { Component, OnInit } from '@angular/core';
import { FichaAnaminese } from './ficha-anaminese';
import { environment } from '../../../environments/environment';

@Component({
    selector: 'ficha-anaminese-cmp',
    moduleId: module.id,
    templateUrl: 'inicio.component.html'
})

export class FichaAnamineseComponent implements OnInit{

    public form = new FichaAnaminese()
    public _fator_rh = ['Positivo', 'Negativo']
    dtOptions: DataTables.Settings = {};

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
