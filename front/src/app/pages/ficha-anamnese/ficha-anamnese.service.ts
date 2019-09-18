import { Injectable, EventEmitter } from '@angular/core';
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
  static fichaAnamneseAlert = new EventEmitter<any>();
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
    .pipe(map((response: any) => response['data']['pacientes']));

  }

  getPacienteById (id): Observable<Paciente[]> {
    return this.http.get<Paciente[]>(this.anamneseUrl +'/'+ id)
    .pipe(map((response: any) => response['data']['paciente'][0]));

  }

  postAnamnese (data: any){
    return this.http.post(
      this.anamneseUrl,
      data,this.httpOptions)
      .subscribe(
        (response) => {
          console.log(response)
          this.MessageService.message(response)
          if(response['status'] == 200)
          FichaAnamneseService.fichaAnamneseAlert.emit(response)
        }
        )
  }

}
