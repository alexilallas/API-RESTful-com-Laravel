import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class InicioService {

  private inicioURL: string;

  constructor
    (
      private http: HttpClient,
  ) {
    console.log('InicioService')
    this.inicioURL = environment.baseAPI + 'inicio'
  }

  getDashboardData(): Observable<any> {
    return this.http.get<any>(this.inicioURL)
      .pipe(map((response: any) => response.data));

  }

  getChartByAno(ano): Observable<any> {
    return this.http.get<any>(this.inicioURL + '/' + ano)
      .pipe(map((response: any) => response.data));
  }
}
