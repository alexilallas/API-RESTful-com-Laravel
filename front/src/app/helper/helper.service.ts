import { Injectable } from '@angular/core';
import { SidebarComponent } from '../sidebar/sidebar.component';

@Injectable({
  providedIn: 'root'
})
export class HelperService extends SidebarComponent {

  constructor() {
    super();
  }

  async delay(ms: number) {
    await new Promise(resolve => setTimeout(() => resolve(), ms));
  }

  hasPermission(url) {
    let itemsMenu = this.menuItems
    let permissoes = JSON.parse(atob(localStorage.getItem('permissoes')))
    let itemToVerify: any

    for (let item of itemsMenu) {
      if (item.path == url) {
        itemToVerify = item
      }
    }

    for (let permissao of permissoes) {
      if (itemToVerify.permission.indexOf(permissao) === 0) {
        return true
      }
    }
    return false
  }

  filterArray(array) {
    var index = -1,
      arr_length = array ? array.length : 0,
      resIndex = -1,
      result = [];

    while (++index < arr_length) {
      var value = array[index];

      if (value) {
        result[++resIndex] = value;
      }
    }

    return result;
  }
}
