import { Component, OnInit } from '@angular/core';


export interface RouteInfo {
    path: string;
    title: string;
    icon: string;
    class: string;
}

export const ROUTES: RouteInfo[] = [
    { path: '/inicio',          title: 'Início',              icon:'nc-bank',             class: '' },
    { path: '/pacientes',       title: 'Cadastro',            icon:'nc-single-02',        class: '' },
    { path: '/ficha-anaminese', title: 'Ficha de Anaminese',  icon:'nc-bullet-list-67',   class: '' },
    { path: '/exame-fisico',    title: 'Exame Físico',        icon:'nc-favourite-28',     class: '' },
    { path: '/prontuario',      title: 'Prontuário',          icon:'nc-paper',            class: '' },
    { path: '/pesquisar',       title: 'Pesquisar',           icon:'nc-zoom-split',       class: '' },
    { path: '/inventario',      title: 'Inventário',          icon:'nc-app',              class: '' },
];

@Component({
    moduleId: module.id,
    selector: 'sidebar-cmp',
    templateUrl: 'sidebar.component.html',
})

export class SidebarComponent implements OnInit {
    public menuItems: any[];
    ngOnInit() {
        this.menuItems = ROUTES.filter(menuItem => menuItem);
    }
}
