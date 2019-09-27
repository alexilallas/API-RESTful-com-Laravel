import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../auth/login/login.service';

@Component({
  selector: 'app-admin-layout',
  templateUrl: './admin-layout.component.html',
  styleUrls: ['./admin-layout.component.scss']
})
export class AdminLayoutComponent implements OnInit {

  public islogged: boolean;


  constructor(private loginService: LoginService) {
    console.log('AdminLayoutComponent')
  }

  ngOnInit() {
    this.islogged = JSON.parse(localStorage.getItem('isLogged'))
  }

}
