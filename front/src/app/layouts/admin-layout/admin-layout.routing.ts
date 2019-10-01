import { Routes } from '@angular/router';

import { InicioComponent } from '../../pages/inicio/inicio.component';
import { PacienteComponent } from '../../pages/paciente/paciente.component';
import { HistoricoMedicoComponent } from '../../pages/historico-medico/historico-medico.component';
import { ExameFisicoComponent } from '../../pages/exame-fisico/exame-fisico.component';
import { ProntuarioComponent } from '../../pages/prontuario/prontuario.component';
import { PesquisarComponent } from '../../pages/pesquisar/pesquisar.component';
import { InventarioComponent } from '../../pages/inventario/inventario.component';
import { EvolucaoComponent } from '../../pages/evolucao/evolucao.component';
import { UsuarioComponent } from '../../pages/usuario/usuario.component';

export const AdminLayoutRoutes: Routes = [
    { path: 'inicio',           component: InicioComponent },
    { path: 'paciente',         component: PacienteComponent },
    { path: 'historico-medico', component: HistoricoMedicoComponent },
    { path: 'exame-fisico',     component: ExameFisicoComponent },
    { path: 'evolucao',         component: EvolucaoComponent },
    { path: 'prontuario',       component: ProntuarioComponent },
    { path: 'pesquisar',        component: PesquisarComponent },
    { path: 'inventario',       component: InventarioComponent },
    { path: 'usuario',          component: UsuarioComponent },
];
