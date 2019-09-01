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

  constructor(private http: HttpClient) {
    this.pacientesUrl = environment.baseAPI + 'pacientes';
  }

  getPacientes (): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.pacientesUrl);
  }

}
