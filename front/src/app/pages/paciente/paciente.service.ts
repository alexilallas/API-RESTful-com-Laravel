import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { Paciente } from './paciente';
import { constants } from '../../constants/constants.component';

@Injectable({
  providedIn: 'root'
})
export class PacienteService {
  pacientesUrl: string;

  constructor(private http: HttpClient) {
    this.pacientesUrl = constants.baseAPI+'pacientes';
  }

  getPacientes (): Observable<Paciente[]> {
    console.log(this.pacientesUrl);
    return this.http.get<Paciente[]>(this.pacientesUrl);
  }

}
