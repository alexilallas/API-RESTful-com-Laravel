import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';

import { Paciente } from '../paciente/paciente';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class HistoricoMedicoService {

  static historicoMedicoCreatedAlert;
  static historicoMedicoUpdatedAlert;
  private historicoMedicoUrl: string;

  constructor
    (
      private http: HttpClient,
      private messageService: MessageService,
  ) {
    console.log('HistoricoMedicoService')
    this.historicoMedicoUrl = environment.baseAPI + 'historico'
  }

  getPacientes(): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.historicoMedicoUrl)
      .pipe(map((response: any) => response.data.pacientes));

  }

  getPacienteById(id): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.historicoMedicoUrl + '/' + id)
      .pipe(map((response: any) => response.data.historico));

  }

  postHistorico(data: any) {
    HistoricoMedicoService.historicoMedicoCreatedAlert = new EventEmitter<any>()
    return this.http.post<any>(
      this.historicoMedicoUrl,
      data)
      .subscribe(
        (response) => {
          this.messageService.message(response)
          if (response.status == 200) {
            HistoricoMedicoService.historicoMedicoCreatedAlert.emit(response)
          }
        }
      )
  }

  updateHistorico(data: any) {
    HistoricoMedicoService.historicoMedicoUpdatedAlert = new EventEmitter<any>()
    return this.http.put<any>(
      this.historicoMedicoUrl,
      data)
      .subscribe(
        (response) => {
          this.messageService.message(response)
          if (response.status == 200) {
            HistoricoMedicoService.historicoMedicoUpdatedAlert.emit(response)
          }
        }
      )
  }

}
