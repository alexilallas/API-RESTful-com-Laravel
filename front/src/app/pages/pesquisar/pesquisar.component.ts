import { Component,OnInit } from '@angular/core';
import { environment } from '../../../environments/environment';

@Component({
    moduleId: module.id,
    selector: 'pesquisar-cmp',
    templateUrl: 'pesquisar.component.html'
})

export class PesquisarComponent implements OnInit {
    dtOptions: DataTables.Settings = {};
    
    ngOnInit() {
        this.dtOptions = environment.dtOptions
    }
}
