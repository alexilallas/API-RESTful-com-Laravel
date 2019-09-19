import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';
import { Paciente } from './paciente';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';
// import { EventEmitter } from 'protractor';

@Injectable({
  providedIn: 'root'
})
export class PacienteService {

  static pacienteCreatedAlert = new EventEmitter<any>();
  static pacienteUpdatedAlert = new EventEmitter<any>();
  private pacientesUrl: string;
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor
    (
    private http: HttpClient,
    private MessageService:MessageService,
    ) {
    console.log('PacienteService')
    this.pacientesUrl = environment.baseAPI + 'paciente'
  }

  getPacientes (): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.pacientesUrl)
    .pipe(map((response: any) => response['data']['pacientes']));

  }

  getPacienteById (id): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.pacientesUrl +'/'+ id)
    .pipe(map((response: any) => response['data']['paciente'][0]));

  }

  postPaciente (paciente: Paciente){
    return this.http.post(
      this.pacientesUrl,
      paciente,this.httpOptions)
      .subscribe(
        (response) => {
          console.log(response)
          this.MessageService.message(response)
          if(response['status'] == 200)
          PacienteService.pacienteCreatedAlert.emit(response)
        }
      )
  }

  updatePaciente (paciente: Paciente){
    return this.http.put(
      this.pacientesUrl,
      paciente,this.httpOptions)
      .subscribe(
        (response) => {
          console.log(response)
          this.MessageService.message(response)
          if(response['status'] == 200)
          PacienteService.pacienteUpdatedAlert.emit(response)
        }
      )
  }

}
