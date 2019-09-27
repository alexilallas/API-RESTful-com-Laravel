import { Component, OnInit } from '@angular/core';
import { LoginService } from './login.service';
import { Login } from './login';

@Component({
  selector: 'app-auth',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public form  = new Login();

  constructor(
    private loginService: LoginService
  ) {
    console.log('LoginComponent')
    loginService.isLogged()
  }

  ngOnInit() {
  }

  login(){
    console.log(this.form)
    this.loginService.login()
  }

}
