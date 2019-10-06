import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { LoginService } from './login.service';
import { Login } from './login';
import { ResetPassword } from './reset-password';
import { NgxSmartModalService } from 'ngx-smart-modal';

@Component({
  selector: 'app-auth',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public loading: boolean = false;
  public form = new Login();
  public formResetPassword = new ResetPassword();
  public modal = 'resetPasswordModal';

  constructor(
    private loginService: LoginService,
    private router: Router,
    public ngxSmartModalService: NgxSmartModalService,
  ) {
    this.guardLogin()
    console.log('LoginComponent')
  }

  ngOnInit() {

  }

  login() {
    this.loading = true
    this.loginService.login(this.form).subscribe(
      response => {
        if (response.error) {
          this.loading = false
        }
      });
  }

  guardLogin() {
    if (this.loginService.isLogged()) {
      this.router.navigate(['/inicio'])
    }
  }

  redefinirSenha() {
    this.loginService.reset(this.formResetPassword)
  }

  close() {
    this.eraseForm()
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.formResetPassword = {}
  }

}
