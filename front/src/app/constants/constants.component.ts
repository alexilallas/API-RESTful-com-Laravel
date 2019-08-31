import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-constants'
})

export class constants{

  public static get baseAPI(): string { return "http://localhost:8000/api/"; }  
  
}
