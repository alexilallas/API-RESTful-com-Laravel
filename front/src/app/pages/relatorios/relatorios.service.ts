import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class RelatoriosService {

  private relatorioURL: string;

  constructor
    (
      private http: HttpClient,
  ) {
    console.log('RelatoriosService')
    this.relatorioURL = environment.baseAPI + 'relatorio'
  }

  getBase(): Observable<any> {
    return this.http.get<any>(this.relatorioURL)
      .pipe(map((response: any) =>
        response.data.anos
      ));

  }
}
