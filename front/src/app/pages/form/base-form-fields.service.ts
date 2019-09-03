import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { retry, catchError } from 'rxjs/operators';
import { environment } from '../../../environments/environment';
import { BaseFormFields } from './baseform-fields';

@Injectable({
  providedIn: 'root'
})
export class BaseFormFieldsService {
  baseUrl: string;

  constructor(private http: HttpClient) {
    this.baseUrl = environment.baseAPI + 'form'
    //this.baseUrl = "/assets/data/data.json"
    
  }

   // Http Headers
  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  }

  getFields (): Observable<any[]> {
    return this.http.get<any[]>(this.baseUrl)
    .pipe(
      retry(1),
      catchError(this.errorHandl)
    )
  }

  // Error handling
  errorHandl(error) {
    let errorMessage = '';
    if(error.error instanceof ErrorEvent) {
      // Get client-side error
      errorMessage = error.error.message;
    } else {
      // Get server-side error
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    console.log(errorMessage);
    return throwError(errorMessage);
 }

}
