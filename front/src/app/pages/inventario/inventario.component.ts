import { Component, OnInit } from '@angular/core';
import { Inventario } from './inventario';
import { InventarioService } from './inventario.service';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';
import { formatDate } from '@angular/common';


@Component({
  selector: 'inventario-cmp',
  moduleId: module.id,
  templateUrl: 'inventario.component.html'
})

export class InventarioComponent extends DatatablesComponent implements OnInit {

  public form = new Inventario();
  public modal = 'inventarioModal';
  public itensInventario: any[];

  constructor
    (
      public ngxSmartModalService: NgxSmartModalService
    ) {
    super();
    console.log('InventarioComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
  }
}
