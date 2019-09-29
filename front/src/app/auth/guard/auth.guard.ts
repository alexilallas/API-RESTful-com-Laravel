import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router, CanActivateChild } from '@angular/router';
import { Observable } from 'rxjs';
import { LoginService } from '../login/login.service';
import { MessageService } from '../../services/messages/message.service';
import { HelperService } from '../../helper/helper.service';

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
      return true
    }
    this.messageService.message({ 'message': 'Você precisa estar logado para ter acesso ao sistema!' })
    this.router.navigate(['/login'])
    this.helperService.delay(1500)
      .then(() => {
        location.reload(true);
      });

    return false
  }



}
