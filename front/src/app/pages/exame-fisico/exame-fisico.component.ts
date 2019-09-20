import { Component, OnInit } from '@angular/core';
import { ExameFisico } from './exame-fisico';
import { ExameFisicoService } from './exame-fisico.service';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'exame-fisico-cmp',
  moduleId: module.id,
  templateUrl: 'exame-fisico.component.html'
})

export class ExameFisicoComponent extends DatatablesComponent implements OnInit {

  public form = new ExameFisico();
  public modal = 'exameModal';
  public pacientes: any[];
  public isNewExame: boolean = true;

  constructor
  (
    public ngxSmartModalService: NgxSmartModalService,
    private exameFisicoService: ExameFisicoService
  ) {
    super();
    console.log('ExameFisicoComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.getPacientes()
  }

  getPacientes(): any {
    this.exameFisicoService.getPacientes()
      .subscribe(response => {
        this.pacientes = response
        this.rerenderTable()
      })
  }
}
