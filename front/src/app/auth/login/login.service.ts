import { Injectable } from '@angular/core';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  
  public islogged:boolean;

  constructor(
    private router: Router,
  ) {
    console.log('LoginService')
  }

  isLogged(): boolean {
    this.islogged = JSON.parse(localStorage.getItem('isLogged'));
    
    if (this.islogged) {
      this.router.navigate(['/inicio']);
    } else {
      this.router.navigate(['/login']);
    }

    return this.islogged;
  }

  login() {
    this.islogged = true
    localStorage.setItem('isLogged', JSON.stringify(this.islogged))
    this.router.navigate(['/inicio'])
  }

  logout(){
    localStorage.removeItem('isLogged')
    this.router.navigate(['/login'])
  }

}
