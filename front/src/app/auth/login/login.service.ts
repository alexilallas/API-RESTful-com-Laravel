import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';

import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';


@Injectable({
  providedIn: 'root'
})
export class LoginService {

  private urlLogin: string;

  constructor(
    private router: Router,
    private http: HttpClient,
    private messageService: MessageService,
  ) {
    this.urlLogin = environment.baseAPI
    console.log('LoginService')
  }

  isLogged(): boolean {

    return (localStorage.getItem('user') && localStorage.getItem('token')) ? true : false;
  }

  login(userData: any) {
    return this.http.post<any>(this.urlLogin + 'login', userData)
      .pipe(map(response => {
        this.messageService.message(response)
        console.log(response)
        if (response.status == 200) {
          localStorage.setItem('token', response.data.token)
          localStorage.setItem('user', btoa(JSON.stringify(response.data.user)))
          localStorage.setItem('permissoes', btoa(JSON.stringify(response.data.permissoes)))
          this.router.navigate(['/inicio'])
        }
        return response
      }))
  }

  getUser(): any {

    let userCripted = localStorage.getItem('user')
    let user = userCripted ? JSON.parse(atob(userCripted)) : null
    let token = localStorage.getItem('token')

    return { 'user': user, 'token': token ? token : null }
  }

  logout(): any {
    localStorage.clear()
    this.router.navigate(['/login'])
    // return this.http.get<any>(this.urlLogin + 'logout')
    //   .pipe(map(response => {
    //     this.messageService.message(response)
    //     if (response.status == 200) {
    //       localStorage.clear()
    //       this.router.navigate(['/login'])
    //     }
    //     return response;
    //   }));
  }

  canReset(userData: any): Observable<any> {
    return this.http.post<any>(
      this.urlLogin + 'can-reset', userData)
  }

  reset(userData: any): Observable<any> {
    return this.http.post<any>(
      this.urlLogin + 'reset', userData)
  }

}
