import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { DataTablesModule } from 'angular-datatables';
import { ReactiveFormsModule } from '@angular/forms';
import { NgSelectModule } from '@ng-select/ng-select';
import { NgxSmartModalModule } from 'ngx-smart-modal';
import { NgxMaskModule } from 'ngx-mask'

import { AdminLayoutRoutes } from './admin-layout.routing';

import { InicioComponent } from '../../pages/inicio/inicio.component';
import { PacienteComponent } from '../../pages/paciente/paciente.component';
import { HistoricoMedicoComponent } from '../../pages/historico-medico/historico-medico.component';
import { ExameFisicoComponent } from '../../pages/exame-fisico/exame-fisico.component';
import { ProntuarioComponent } from '../../pages/prontuario/prontuario.component';
import { PesquisarComponent } from '../../pages/pesquisar/pesquisar.component';
import { InventarioComponent } from '../../pages/inventario/inventario.component';
import { EvolucaoComponent } from '../../pages/evolucao/evolucao.component';
import { LoginComponent } from '../../auth/login/login.component';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(AdminLayoutRoutes),
    FormsModule,
    NgbModule,
    DataTablesModule,
    ReactiveFormsModule,
    NgSelectModule,
    NgxSmartModalModule,
    NgxMaskModule
  ],
  declarations: [
    InicioComponent,
    PacienteComponent,
    HistoricoMedicoComponent,
    ExameFisicoComponent,
    ProntuarioComponent,
    PesquisarComponent,
    InventarioComponent,
    EvolucaoComponent,
    LoginComponent,
  ]
})

export class AdminLayoutModule { }
