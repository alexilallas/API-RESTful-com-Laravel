import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class ProntuarioService {

  private prontuarioUrl: string;
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor
    (
      private http: HttpClient,
      private MessageService: MessageService,
  ) {
    console.log('ProntuarioService')
    this.prontuarioUrl = environment.baseAPI + 'prontuario'
  }

  getPacientes(): Observable<any[]> {
    return this.http.get<any[]>(this.prontuarioUrl)
      .pipe(map((response: any) => response['data']['pacientes']));

  }

  getPacienteById(id): Observable<any[]> {
    return this.http.get<any[]>(this.prontuarioUrl + '/' + id)
      .pipe(map((response: any) => response['data']['prontuario']));

  }
}
