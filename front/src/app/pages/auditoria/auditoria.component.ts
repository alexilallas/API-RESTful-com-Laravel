import { Component, OnInit } from '@angular/core';

import { environment } from 'environments/environment';
import { AuditoriaService } from './auditoria.service';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'app-auditoria',
  templateUrl: './auditoria.component.html',
  styleUrls: ['./auditoria.component.scss']
})
export class AuditoriaComponent extends DatatablesComponent implements OnInit {

  public registros: any = [];

  constructor(
    private auditoriaService: AuditoriaService,
  ) {
    super();
    console.log('AuditoriaComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.dtOptions.order = [3, 'desc']
    this.getRegistros()
  }

  getRegistros() {
    this.auditoriaService.getRegistros()
      .subscribe(response => {
        this.registros = response
        this.rerenderTable()
      })
  }

}
