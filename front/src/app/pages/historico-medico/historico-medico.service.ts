import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';
import { Paciente } from '../paciente/paciente';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class HistoricoMedicoService {
  static historicoMedicoCreatedAlert = new EventEmitter<any>();
  static historicoMedicoUpdatedAlert = new EventEmitter<any>();
  private historicoMedicoUrl: string;
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor
    (
      private http: HttpClient,
      private MessageService: MessageService,
  ) {
    console.log('HistoricoMedicoService')
    this.historicoMedicoUrl = environment.baseAPI + 'historico'
  }

  getPacientes(): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.historicoMedicoUrl)
      .pipe(map((response: any) => response['data']['pacientes']));

  }

  getPacienteById(id): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.historicoMedicoUrl + '/' + id)
      .pipe(map((response: any) => response['data']['paciente'][0]));

  }

  postHistorico(data: any) {
    return this.http.post(
      this.historicoMedicoUrl,
      data, this.httpOptions)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response['status'] == 200)
          HistoricoMedicoService.historicoMedicoCreatedAlert.emit(response)
        }
      )
  }

  updateHistorico(data: any) {
    return this.http.put(
      this.historicoMedicoUrl,
      data, this.httpOptions)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response['status'] == 200)
          HistoricoMedicoService.historicoMedicoUpdatedAlert.emit(response)
        }
      )
  }

}
