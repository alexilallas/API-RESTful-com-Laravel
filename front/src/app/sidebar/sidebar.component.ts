import { Component, OnInit } from '@angular/core';


export interface RouteInfo {
    path: string;
    title: string;
    icon: string;
    class: string;
    permission: string;
}

export const ROUTES: RouteInfo[] = [
    { path: '/inicio',           title: 'Início',              icon:'nc-bank',             class: '',  permission: 'visualizarDashboard' },
    { path: '/paciente',         title: 'Paciente',            icon:'nc-single-02',        class: '',  permission: 'criarPaciente' },
    { path: '/historico-medico', title: 'Histórico Médico',    icon:'nc-single-copy-04',   class: '',  permission: 'criarHistoricoMedico'},
    { path: '/exame-fisico',     title: 'Exame Físico',        icon:'nc-favourite-28',     class: '',  permission: 'criarExameFisico'},
    { path: '/evolucao',         title: 'Evolução',            icon:'nc-sound-wave',       class: '',  permission: 'criarEvolucao'},
    { path: '/prontuario',       title: 'Prontuário',          icon:'nc-paper',            class: '',  permission: 'visualizarProntuario'},
    { path: '/inventario',       title: 'Inventário',          icon:'nc-app',              class: '',  permission: 'criarItem'},
    { path: '/usuario',          title: 'Usuário',             icon:'nc-circle-10',        class: '',  permission: 'criarUsuario'},
    { path: '/relatorio',        title: 'Relatório',           icon:'nc-book-bookmark',    class: '',  permission: 'visualizarRelatorio'},
    { path: '/auditoria',        title: 'Auditoria',           icon:'nc-zoom-split',       class: '',  permission: 'visualizarAuditoria'},
];

@Component({
    moduleId: module.id,
    selector: 'sidebar-cmp',
    templateUrl: 'sidebar.component.html',
})

export class SidebarComponent implements OnInit {
    public menuItems: any[];

    constructor(){
      this.menuItems = ROUTES.filter(menuItem => menuItem);
    }
    ngOnInit() {
      console.log('SidebarComponent')
    }
}
