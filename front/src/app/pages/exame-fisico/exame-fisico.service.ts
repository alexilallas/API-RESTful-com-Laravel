import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map, filter, switchMap } from 'rxjs/operators';
import { ExameFisico } from './exame-fisico';
import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';

@Injectable({
  providedIn: 'root'
})
export class ExameFisicoService {

  static exameFisicoCreatedAlert;
  static exameFisicoUpdatedAlert;
  private exameFisicoUrl: string;
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor
    (
      private http: HttpClient,
      private MessageService: MessageService,
  ) {
    console.log('ExameFisicoService')
    this.exameFisicoUrl = environment.baseAPI + 'exame'
  }

  getPacientes(): Observable<ExameFisico[]> {
    return this.http.get<ExameFisico[]>(this.exameFisicoUrl)
      .pipe(map((response: any) => response.data.pacientes));

  }

  getPacienteById(id): Observable<ExameFisico[]> {
    return this.http.get<ExameFisico[]>(this.exameFisicoUrl + '/' + id)
      .pipe(map((response: any) => response.data.paciente));

  }

  postExame(data: any) {
    ExameFisicoService.exameFisicoCreatedAlert = new EventEmitter<any>()
    return this.http.post<any>(
      this.exameFisicoUrl,
      data, this.httpOptions)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response.status == 200) {
            ExameFisicoService.exameFisicoCreatedAlert.emit(response)
          }
        }
      )
  }

  updateExame(data: any) {
    ExameFisicoService.exameFisicoUpdatedAlert = new EventEmitter<any>()
    return this.http.put<any>(
      this.exameFisicoUrl,
      data, this.httpOptions)
      .subscribe(
        (response) => {
          this.MessageService.message(response)
          if (response.status == 200) {
            ExameFisicoService.exameFisicoUpdatedAlert.emit(response)
          }
        }
      )
  }
}
