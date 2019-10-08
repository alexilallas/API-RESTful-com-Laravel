import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../auth/login/login.service';

@Component({
  selector: 'app-admin-layout',
  templateUrl: './admin-layout.component.html',
  styleUrls: ['./admin-layout.component.scss']
})
export class AdminLayoutComponent implements OnInit {

  constructor(
    private loginService: LoginService,
  ) {
    console.log('AdminLayoutComponent')
  }

  ngOnInit() {
  }

  userLoged() {
    return this.loginService.isLogged()
  }

}
