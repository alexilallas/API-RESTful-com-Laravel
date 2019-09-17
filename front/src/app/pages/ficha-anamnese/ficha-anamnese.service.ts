import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';
import { Paciente } from '../paciente/paciente';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class FichaAnamneseService {
  private anamneseUrl: string;
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor
  (
    private http: HttpClient,
    private MessageService:MessageService,
  ) {
    console.log('AnamneseService')
    this.anamneseUrl = environment.baseAPI + 'anamnese'
   }

  ngOnInit(){

  }

  getPacientes (): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.anamneseUrl)
    .pipe(map((response: any) => response['data']));

  }

}
