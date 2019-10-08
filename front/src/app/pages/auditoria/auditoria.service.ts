import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';

import { environment } from 'environments/environment';

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

  getRegistros(): Observable<any> {
    return this.http.get<any>(
      this.auditoriaUrl)
      .pipe(map((response: any) => response.data));
  }
}
