import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router } from '@angular/router';
import { Observable } from 'rxjs';

import { LoginService } from '../login/login.service';
import { HelperService } from '../../helper/helper.service';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(
    private loginService: LoginService,
    private router: Router,
    private messageService: MessageService,
    private helperService: HelperService,
  ) { }

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {

    if (this.loginService.isLogged()) {
      console.log('Usuário logado')
      if (!this.helperService.hasPermission(state.url)) {
        console.log('Usuário Sem Permissao')
        this.messageService.message({ 'message': 'Você não tem permissão para ver este conteúdo!' })
        this.router.navigate(['/inicio'])
        return false
      } else {
        return true
      }

    } else {
      this.messageService.message({ 'message': 'Você precisa estar logado para ter acesso ao sistema!' })
      this.router.navigate(['/login'])
      return false
    }

  }

}
