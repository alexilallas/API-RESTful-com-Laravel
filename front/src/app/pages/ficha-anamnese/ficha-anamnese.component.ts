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
        this.form['outro'] = ""
        this.form['vacina_dt'] = false
        this.form['vacina_hb'] = false
        this.form['vacina_fa'] = false
        this.form['vacina_influenza'] = false
        this.form['vacina_antirrabica'] = false
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
      this.saveFichaAnamnese()
      FichaAnamneseService.fichaAnamneseAlert.subscribe(
        () =>{
          this.form = {},
          this.getPacientes(),
          this.close()
        }
      )
    }

    close(){
      this.form = {}
      this.ngxSmartModalService.close(this.modal)
    }

    saveFichaAnamnese(){
      this.anamineseService.postAnamnese(this.form)
    }

    openFormEdit(id){
      this.isNewAnamnese = false
      this.form['paciente_id'] = id
      this.anamineseService.getPacienteById(id)
      .subscribe(response => {
        console.log(response)
        this.form = response
      })
      this.ngxSmartModalService.open(this.modal)
    }

    openFormNew(id){
      this.isNewAnamnese = true
      this.form['paciente_id'] = id
      this.ngxSmartModalService.open(this.modal)
    }

    eraseForm(){
      this.form = {}
    }

}
