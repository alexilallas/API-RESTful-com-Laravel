import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'environments/environment';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuditoriaService {

  private auditoriaUrl: string;

  constructor(
    private http: HttpClient,
  ) {
    console.log('AuditoriaService')
    this.auditoriaUrl = environment.baseAPI + 'auditoria'
  }

  getRegistros() : Observable<any> {
    return this.http.get<any>(
      this.auditoriaUrl)
  }
}
