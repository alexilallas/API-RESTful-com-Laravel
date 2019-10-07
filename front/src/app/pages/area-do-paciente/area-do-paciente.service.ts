import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';


@Injectable({
  providedIn: 'root'
})
export class AreaDoPacienteService {

  private areaDoPacienteUrl: string;


  constructor
    (
      private http: HttpClient,
  ) {
    console.log('AreaDoPacienteService')
    this.areaDoPacienteUrl = environment.baseAPI + 'area-do-paciente'
  }

  getProntuario(data) {
    return this.http.post<any>(this.areaDoPacienteUrl, data)
  }

}
