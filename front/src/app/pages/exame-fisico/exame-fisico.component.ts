import { Component, OnInit } from '@angular/core';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';
import { environment } from 'environments/environment';

@Component({
    selector: 'exame-fisico-cmp',
    moduleId: module.id,
    templateUrl: 'exame-fisico.component.html'
})

export class ExameFisicoComponent extends DatatablesComponent implements OnInit {

    public dtOptions: DataTables.Settings = {};

    constructor() {
        super();
    }

    ngOnInit() {
        this.dtOptions = environment.dtOptions
    }
}
