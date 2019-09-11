import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class FichaAnamineseService {

  constructor
  (
    private http: HttpClient,
  ) { }

  ngOnInit(){
    
  }

  // getModal(){
  //   this.http.get('ficha-anaminese.component.html', {responseType: 'text'})
  //     .subscribe(data => console.log(data));
  // }
}
