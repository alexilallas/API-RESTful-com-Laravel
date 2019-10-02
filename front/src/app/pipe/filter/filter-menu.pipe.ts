import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'filterMenu'
})
export class FilterMenuPipe implements PipeTransform {

  transform(itemsMenu: any[]): any[] {
    let permissoes = JSON.parse(atob(localStorage.getItem('permissoes')))
    return itemsMenu.map(itemMenu => {
      for (let permissao of permissoes) {
        if (itemMenu.permission.indexOf(permissao) === 0) {
          return itemMenu
        }
      }
      return []
    });
  }

}
