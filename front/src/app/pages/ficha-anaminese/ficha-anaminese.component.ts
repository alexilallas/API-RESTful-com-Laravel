import { Component, OnInit } from '@angular/core';
import { FichaAnaminese } from './ficha-anaminese';

@Component({
    selector: 'ficha-anaminese-cmp',
    moduleId: module.id,
    templateUrl: 'ficha-anaminese.component.html'
})

export class FichaAnamineseComponent implements OnInit{

    public form = new FichaAnaminese()

    ngOnInit(){
        this.form['diabetes'] = "0"
        this.form['hipertensao'] = "0"
        this.form['infarto'] = "0"
        this.form['morte_subita'] = "0"
        this.form['cancer'] = "0"
        this.form['fuma'] = "0"
        this.form['alcool'] = "0"
        this.form['hipertenso'] = "0"
        this.form['alergico'] = "0"
        this.form['atividade_fisica'] = "0"
        this.form['cirurgia'] = "0"
    }


    onSubmit() {
        console.log(this.form)
    }
}
