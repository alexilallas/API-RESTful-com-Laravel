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
      console.log(err)
      const errorMessage = err.error.message
      const statusText = err.statusText
      const errorName = err.name

      if (statusText === 'Unauthorized' && errorMessage == 'Token not provided') {
        this.loginService.logout()
        this.messageService.message({ 'message': 'Você não tem permissão para ver este conteúdo!' })
      }
      if (statusText != 'Unauthorized' && errorName == 'HttpErrorResponse') {
        this.messageService.message({ 'message': 'Falha ao conectar com o servidor' })
      }
      else if (errorMessage == 'Token has expired') {
        this.loginService.logout()
        this.messageService.message({ 'message': 'Sessão expirada, faça login novamente para continuar' })
      }
      else {
        this.messageService.message({ 'message': errorMessage })
      }


      return throwError(errorMessage)
    }))
  }
}
