import { Routes } from '@angular/router';

import { InicioComponent } from '../../pages/inicio/inicio.component';
import { PacienteComponent } from '../../pages/paciente/paciente.component';
import { HistoricoMedicoComponent } from '../../pages/historico-medico/historico-medico.component';
import { ExameFisicoComponent } from '../../pages/exame-fisico/exame-fisico.component';
import { ProntuarioComponent } from '../../pages/prontuario/prontuario.component';
import { InventarioComponent } from '../../pages/inventario/inventario.component';
import { EvolucaoComponent } from '../../pages/evolucao/evolucao.component';
import { UsuarioComponent } from '../../pages/usuario/usuario.component';
import { AuditoriaComponent } from '../../pages/auditoria/auditoria.component';
import { RelatorioComponent } from '../../pages/relatorios/relatorios.component';

import { AuthGuard } from '../../auth/guard/auth.guard';

export const AdminLayoutRoutes: Routes = [
    { path: 'inicio',           component: InicioComponent,          canActivate: [AuthGuard] },
    { path: 'paciente',         component: PacienteComponent,        canActivate: [AuthGuard] },
    { path: 'historico-medico', component: HistoricoMedicoComponent, canActivate: [AuthGuard] },
    { path: 'exame-fisico',     component: ExameFisicoComponent,     canActivate: [AuthGuard] },
    { path: 'evolucao',         component: EvolucaoComponent,        canActivate: [AuthGuard] },
    { path: 'prontuario',       component: ProntuarioComponent,      canActivate: [AuthGuard] },
    { path: 'inventario',       component: InventarioComponent,      canActivate: [AuthGuard] },
    { path: 'usuario',          component: UsuarioComponent,         canActivate: [AuthGuard] },
    { path: 'auditoria',        component: AuditoriaComponent,       canActivate: [AuthGuard] },
    { path: 'relatorio',        component: RelatorioComponent,       canActivate: [AuthGuard] },
];
