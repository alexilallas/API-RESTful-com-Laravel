import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { LoginService } from '../../auth/login/login.service';
import { MessageService } from '../messages/message.service';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
  constructor(
    private loginService: LoginService,
    private messageService: MessageService,
  ) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      if (err.status === 401) {
        this.loginService.logout();
        this.messageService.message({ 'message': 'Você não tem permissão para ver este conteúdo!' })
      }

      const error = err.error.message || err.statusText;
      return throwError(error);
    }))
  }
}
