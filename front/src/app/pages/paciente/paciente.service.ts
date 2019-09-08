import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { Paciente } from './paciente';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class PacienteService {
  pacientesUrl: string;
  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor(private http: HttpClient) {
    this.pacientesUrl = environment.baseAPI + 'paciente';
  }

  /** GET: Retorna todos os pacientes */
  getPacientes (): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.pacientesUrl);
  }

  /** POST: Adiciona um novo paciente */
  postPaciente (paciente: Paciente){
    return this.http.post(
      this.pacientesUrl,
      paciente,this.httpOptions)
      .subscribe(
        (data) => {
          console.log(data)
        }
        )
  }

}
