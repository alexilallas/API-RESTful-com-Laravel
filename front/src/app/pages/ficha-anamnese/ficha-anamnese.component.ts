import { Component, OnInit } from '@angular/core';
import { FichaAnamnese } from './ficha-anamnese';
import { FichaAnamneseService } from './ficha-anamnese.service';
import { PacienteService } from '../paciente/paciente.service';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';

@Component({
    selector: 'ficha-anamnese-cmp',
    moduleId: module.id,
    templateUrl: 'ficha-anamnese.component.html'
})

export class FichaAnamneseComponent implements OnInit{

    public form = new FichaAnamnese();
    public _fator_rh = ['Positivo', 'Negativo'];
    private dtOptions: DataTables.Settings = {};
    public PacientesAguardandoAtendimento:any;
    public showTitle:boolean = false;

    constructor
    (
        private pacienteService:PacienteService,
        public ngxSmartModalService: NgxSmartModalService,
        private anamineseService: FichaAnamneseService,
    ){}

    ngOnInit(){
        this.form['dt'] = false
        this.form['hb'] = false
        this.form['fa'] = false
        this.form['influenza'] = false
        this.form['antirrabica'] = false
        this.dtOptions = environment.dtOptions
        this.aguardandoAtendimento()
    }


    onSubmit() {
      console.log(this.form)
    }

    aguardandoAtendimento() : any{
      this.anamineseService.getPacientes()
      .subscribe(response => {
        console.log(response)
        this.PacientesAguardandoAtendimento = response['pacientes']
        if(response['pacientes'].length > 0){
          this.showTitle = true;
        }
      })
    }
}
