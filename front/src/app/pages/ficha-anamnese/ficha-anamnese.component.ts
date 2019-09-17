import { Component, OnInit } from '@angular/core';
import { FichaAnamnese } from './ficha-anamnese';
import { FichaAnamneseService } from './ficha-anamnese.service';
import { PacienteService } from '../paciente/paciente.service';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
    selector: 'ficha-anamnese-cmp',
    moduleId: module.id,
    templateUrl: 'ficha-anamnese.component.html'
})

export class FichaAnamneseComponent extends DatatablesComponent implements OnInit{

    public _fator_rh = ['Positivo', 'Negativo'];
    public dtOptions: DataTables.Settings = {};
    
    public form = new FichaAnamnese();
    public modal = 'fichaAnamneseModal';
    public pacientes: any;
    public isNewAnamnese:boolean = false;

    constructor
    (
        private pacienteService:PacienteService,
        public ngxSmartModalService: NgxSmartModalService,
        private anamineseService: FichaAnamneseService,
    ){
        super();
    }

    ngOnInit(){
        this.form['dt'] = false
        this.form['hb'] = false
        this.form['fa'] = false
        this.form['influenza'] = false
        this.form['antirrabica'] = false
        this.dtOptions = environment.dtOptions
        this.getPacientes()
    }


    getPacientes(): any {
        this.anamineseService.getPacientes()
        .subscribe(response => {
            console.log(response)
            this.pacientes = response,
            this.rerenderTable()
        })
    }

    save(){
        console.log(this.form)
        this.anamineseService.postAnamnese(this.form)
    }

    openFormEdit(id){
        this.isNewAnamnese = false
        console.log(id)
        this.anamineseService.getPacienteById(id)
        .subscribe(response => {
            console.log(response)
        })
        this.ngxSmartModalService.open(this.modal)
    }

    openFormNew(){
        this.isNewAnamnese = true
        this.ngxSmartModalService.open(this.modal)
    }

    close(){
        this.form = {}
        this.ngxSmartModalService.close(this.modal)
      }

}
