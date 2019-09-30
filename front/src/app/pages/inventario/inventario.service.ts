import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';
import { Inventario } from './inventario';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class InventarioService {

  static itemUpdatedAlert;
  static itemCreatedAlert;
  private inventarioUrl: string;

  constructor
    (
      private http: HttpClient,
      private MessageService: MessageService,
  ) {
    console.log('InventarioService')
    this.inventarioUrl = environment.baseAPI + 'inventario'
  }

  getItens(): Observable<Inventario[]> {
    return this.http.get<Inventario[]>(this.inventarioUrl)
      .pipe(map((response: any) => response.data.itens));

  }

  getItemById(id): Observable<Inventario[]> {
    return this.http.get<Inventario[]>(this.inventarioUrl + '/' + id)
      .pipe(map((response: any) => response.data.item[0]));

  }

  postItem(item: Inventario) {
    InventarioService.itemCreatedAlert = new EventEmitter<any>()
    return this.http.post<any>(
      this.inventarioUrl,
      item)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response.status == 200) {
            InventarioService.itemCreatedAlert.emit(response)
          }
        }
      )
  }

  updateItem(item: Inventario) {
    InventarioService.itemUpdatedAlert = new EventEmitter<any>()
    return this.http.put<any>(
      this.inventarioUrl,
      item)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response.status == 200) {
            InventarioService.itemUpdatedAlert.emit(response)
          }
        }
      )
  }
}
