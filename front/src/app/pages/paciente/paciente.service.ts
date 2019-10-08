import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { Paciente } from './paciente';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class PacienteService {

  static pacienteCreatedAlert;
  static pacienteUpdatedAlert;
  private pacientesUrl: string;

  constructor
    (
      private http: HttpClient,
      private messageService: MessageService,
  ) {
    console.log('PacienteService')
    this.pacientesUrl = environment.baseAPI + 'paciente'
  }

  getPacientes(): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.pacientesUrl)
      .pipe(map((response: any) => response.data.pacientes));

  }

  getPacienteById(id): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.pacientesUrl + '/' + id)
      .pipe(map((response: any) => response.data.paciente));

  }

  postPaciente(paciente: Paciente) {
    PacienteService.pacienteCreatedAlert = new EventEmitter<any>()
    return this.http.post<any>(
      this.pacientesUrl,
      paciente)
      .subscribe(
        (response) => {
          this.messageService.message(response)
          if (response.status == 200) {
            PacienteService.pacienteCreatedAlert.emit(response)
          }
        }
      )
  }

  updatePaciente(paciente: Paciente) {
    PacienteService.pacienteUpdatedAlert = new EventEmitter<any>()
    return this.http.put<any>(
      this.pacientesUrl,
      paciente)
      .subscribe(
        (response) => {
          this.messageService.message(response)
          if (response.status == 200) {
            PacienteService.pacienteUpdatedAlert.emit(response)
          }
        }
      )
  }

}
