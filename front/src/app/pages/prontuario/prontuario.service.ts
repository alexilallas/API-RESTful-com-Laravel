import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';

import { environment } from '../../../environments/environment';


@Injectable({
  providedIn: 'root'
})
export class ProntuarioService {

  private prontuarioUrl: string;


  constructor
    (
      private http: HttpClient,
  ) {
    console.log('ProntuarioService')
    this.prontuarioUrl = environment.baseAPI + 'prontuario'
  }

  getPacientes(): Observable<any> {
    return this.http.get<any>(this.prontuarioUrl)
      .pipe(map((response: any) => response.data.pacientes));

  }

  getPacienteById(id): Observable<any> {
    return this.http.get<any>(this.prontuarioUrl + '/' + id)
      .pipe(map((response: any) => response.data.prontuario));

  }
}
