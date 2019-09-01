import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { DataTablesModule } from 'angular-datatables';
import { NgSelect2Module } from 'ng-select2';
// import { ReactiveFormsModule } from '@angular/forms';


import { AdminLayoutRoutes } from './admin-layout.routing';

import { InicioComponent } from '../../pages/inicio/inicio.component';
import { PacienteComponent } from '../../pages/paciente/paciente.component';
import { FichaAnamineseComponent } from '../../pages/ficha-anaminese/ficha-anaminese.component';
import { ExameFisicoComponent } from '../../pages/exame-fisico/exame-fisico.component';
import { ProntuarioComponent } from '../../pages/prontuario/prontuario.component';
import { PesquisarComponent } from '../../pages/pesquisar/pesquisar.component';
import { InventarioComponent } from '../../pages/inventario/inventario.component';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(AdminLayoutRoutes),
    FormsModule,
    NgbModule,
    DataTablesModule,
    NgSelect2Module,
    // ReactiveFormsModule
  ],
  declarations: [
    InicioComponent,
    PacienteComponent,
    FichaAnamineseComponent,
    ExameFisicoComponent,
    ProntuarioComponent,
    PesquisarComponent,
    InventarioComponent,
  ]
})

export class AdminLayoutModule {}
