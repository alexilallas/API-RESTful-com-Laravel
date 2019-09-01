import { Component,OnInit } from '@angular/core';

declare var google: any;

@Component({
    moduleId: module.id,
    selector: 'pesquisar-cmp',
    templateUrl: 'pesquisar.component.html'
})

export class PesquisarComponent implements OnInit {
    dtOptions: DataTables.Settings = {};
    ngOnInit() {
        this.dtOptions = {
            pagingType: 'full_numbers',
            pageLength: 10,
            dom: 'Bfrtip',
            responsive: true,
            language: {
              processing: "Processando...",
              search: "Pesquisar:",
              lengthMenu: "Mostrar _MENU_ &eacute;l&eacute;ments",
              info: "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
              infoEmpty: "Mostrando 0 / 0 de 0 registros",
              infoFiltered: "(filtrando de _MAX_ registros)",
              infoPostFix: "",
              loadingRecords: "Carregando registros...",
              zeroRecords: "Nenhum registro encontrado",
              emptyTable: "Não há dados disponíveis na tabela",
              paginate: {
                first: "Primeiro",
                previous: "Anterior",
                next: "Próximo",
                last: "Último"
              },
              aria: {
                sortAscending: ": Activar para ordenar la tabla en orden ascendente",
                sortDescending: ": Activar para ordenar la tabla en orden descendente"
              }
            }
          };
    }
}
