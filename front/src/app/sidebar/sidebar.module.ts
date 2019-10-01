import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { SidebarComponent } from './sidebar.component';

import { FilterMenuPipe } from '../pipe/filter/filter-menu.pipe';

@NgModule({
    imports: [RouterModule, CommonModule],
    declarations: [SidebarComponent, FilterMenuPipe],
    exports: [SidebarComponent]
})

export class SidebarModule { }
