import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable } from 'rxjs';
import { LoginService } from '../../auth/login/login.service';
import { environment } from 'environments/environment';


@Injectable()
export class JwtInterceptor implements HttpInterceptor {

  constructor(private loginService: LoginService, ) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const requestUrl = request.url.split('/')
    const urlbase = environment.baseAPI.split('/')
    let userData = this.loginService.getUser()

    if (userData.user && userData.token && (requestUrl[2] === urlbase[2])) {
      request = request.clone({
        setHeaders: {
          Authorization: `Bearer ${userData.token}`
        }
      });
    }

    return next.handle(request);
  }
}
