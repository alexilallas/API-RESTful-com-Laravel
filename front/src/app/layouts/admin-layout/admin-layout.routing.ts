import { Routes } from '@angular/router';

import { InicioComponent } from '../../pages/inicio/inicio.component';
import { PacienteComponent } from '../../pages/paciente/paciente.component';
import { FichaAnamineseComponent } from '../../pages/ficha-anaminese/ficha-anaminese.component';
import { ExameFisicoComponent } from '../../pages/exame-fisico/exame-fisico.component';
import { ProntuarioComponent } from '../../pages/prontuario/prontuario.component';
import { PesquisarComponent } from '../../pages/pesquisar/pesquisar.component';
import { InventarioComponent } from '../../pages/inventario/inventario.component';

export const AdminLayoutRoutes: Routes = [
    { path: 'inicio',           component: InicioComponent },
    { path: 'paciente',         component: PacienteComponent },
    { path: 'ficha-anaminese',  component: FichaAnamineseComponent },
    { path: 'exame-fisico',     component: ExameFisicoComponent },
    { path: 'prontuario',       component: ProntuarioComponent },
    { path: 'pesquisar',        component: PesquisarComponent },
    { path: 'inventario',       component: InventarioComponent },
];
