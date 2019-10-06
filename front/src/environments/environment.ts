// The file contents for the current environment will overwrite these during build.
// The build system defaults to the dev environment which uses `environment.ts`, but if you do
// `ng build --env=prod` then `environment.prod.ts` will be used instead.
// The list of which env maps to which file can be found in `.angular-cli.json`.

export const environment = {
  production: false,
  baseAPI: 'http://localhost:8000/api/',
  dtOptions: {
    pagingType: 'full_numbers',
    pageLength: 5,
    dom: 'Bfrtip',
    responsive: true,
    language: {
      processing: "Processando...",
      search: "",
      searchPlaceholder: "Buscar",
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
        sortAscending: ": Ativar para ordenar a tabela em ordem ascendente",
        sortDescending: ": Ativar para ordenar a tabela em ordem descendente"
      }
    }
  },

};
