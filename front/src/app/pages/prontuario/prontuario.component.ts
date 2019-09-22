import { Component, OnInit } from '@angular/core';
import { Prontuario } from './prontuario';
import { ProntuarioService } from './prontuario.service';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'prontuario-cmp',
  moduleId: module.id,
  templateUrl: 'prontuario.component.html'
})

export class ProntuarioComponent extends DatatablesComponent implements OnInit {

  public form = new Prontuario();
  public modal = 'prontuarioModal';
  public pacientes: any[];

  constructor
    (
      public ngxSmartModalService: NgxSmartModalService,
      private prontuarioService: ProntuarioService
    ) {
    super();
    console.log('ProntuarioComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.getPacientes()
  }

  getPacientes() {
    this.prontuarioService.getPacientes()
      .subscribe(response => {
        this.pacientes = response
        console.log(response)
        this.rerenderTable()
      })
  }

}
