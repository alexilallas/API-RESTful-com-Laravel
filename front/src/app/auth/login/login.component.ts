import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { Login } from './login';
import { LoginService } from './login.service';
import { ResetPassword } from './reset-password';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { MessageService } from '../../services/messages/message.service';

@Component({
  selector: 'app-auth',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public loginLoading: boolean = false;
  public resetLoading: boolean = false;
  public canResetPassword: boolean = false;

  public form = new Login();
  public formResetPassword: any = new ResetPassword();
  public modal = 'resetPasswordModal';

  constructor(
    private loginService: LoginService,
    private router: Router,
    public ngxSmartModalService: NgxSmartModalService,
    private messageService: MessageService,
  ) {
    this.guardLogin()
    console.log('LoginComponent')
  }

  ngOnInit() {

  }

  login() {
    this.loginLoading = true
    this.loginService.login(this.form).subscribe(
      response => {
        if (response.error) {
          this.loginLoading = false
        }
      });
  }

  guardLogin() {
    if (this.loginService.isLogged()) {
      this.router.navigate(['/inicio'])
    }
  }

  verify() {
    this.resetLoading = true
    this.loginService.canReset(this.formResetPassword)
      .subscribe(
        response => {
          console.log(response)
          if (response.status == 200) {
            this.canResetPassword = true
            this.formResetPassword.id = response.data.id
          }
          else {
            this.messageService.message(response)
          }
          this.resetLoading = false
        }
      )
  }

  reset() {
    console.log(this.formResetPassword)
    this.resetLoading = true
    this.loginService.reset(this.formResetPassword)
      .subscribe(
        response => {
          console.log(response)
          if (response.status == 200) {
            this.messageService.message(response)
            this.close()
          }
          else {
            this.messageService.message(response)
          }
          this.resetLoading = false
        }
      )
  }

  close() {
    this.eraseForm()
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.formResetPassword = {}
    this.canResetPassword = false
    this.resetLoading = false
  }

}
