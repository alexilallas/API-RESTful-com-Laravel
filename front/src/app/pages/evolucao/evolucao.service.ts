import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';
import { Evolucao } from './evolucao';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class EvolucaoService {

  static evolucaoCreatedAlert;
  static evolucaoUpdatedAlert;
  private evolucaoUrl: string;
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor
    (
      private http: HttpClient,
      private MessageService: MessageService,
  ) {
    console.log('EvolucaoService')
    this.evolucaoUrl = environment.baseAPI + 'evolucao'
  }

  getPacientes(): Observable<Evolucao[]> {
    return this.http.get<Evolucao[]>(this.evolucaoUrl)
      .pipe(map((response: any) => response['data']['pacientes']));

  }

  getPacienteById(id): Observable<Evolucao[]> {
    return this.http.get<Evolucao[]>(this.evolucaoUrl + '/' + id)
      .pipe(map((response: any) => response['data']['paciente']));

  }

  postEvolucao(data: any) {
    EvolucaoService.evolucaoCreatedAlert = new EventEmitter<any>()
    return this.http.post(
      this.evolucaoUrl,
      data, this.httpOptions)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response['status'] == 200) {
            EvolucaoService.evolucaoCreatedAlert.emit(response)
          }
        }
      )
  }

  updateEvolucao(data: any) {
    EvolucaoService.evolucaoUpdatedAlert = new EventEmitter<any>()
    return this.http.put(
      this.evolucaoUrl,
      data, this.httpOptions)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response['status'] == 200) {
            EvolucaoService.evolucaoUpdatedAlert.emit(response)
          }
        }
      )
  }
}
