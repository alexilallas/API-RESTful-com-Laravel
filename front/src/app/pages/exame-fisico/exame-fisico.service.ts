import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map} from 'rxjs/operators';
import { Observable } from 'rxjs';

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


  constructor
    (
      private http: HttpClient,
      private messageService: MessageService,
  ) {
    console.log('ExameFisicoService')
    this.exameFisicoUrl = environment.baseAPI + 'exame'
  }

  getPacientes(): Observable<ExameFisico[]> {
    return this.http.get<ExameFisico[]>(this.exameFisicoUrl)
      .pipe(map((response: any) => response.data.pacientes));

  }

  getPacienteById(id): Observable<any> {
    return this.http.get<ExameFisico[]>(this.exameFisicoUrl + '/' + id)
      .pipe(map((response: any) => response.data.exameFisico));

  }

  getEvolucaoByIdAndDate(id, data): Observable<any> {
    return this.http.get<ExameFisico[]>(this.exameFisicoUrl + '/' + id + '/' + data)
      .pipe(map((response: any) => response.data.exameFisico[0]));

  }

  postExame(data: any) {
    ExameFisicoService.exameFisicoCreatedAlert = new EventEmitter<any>()
    return this.http.post<any>(
      this.exameFisicoUrl,
      data)
      .subscribe(
        (response) => {
          this.messageService.message(response)
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
      data)
      .subscribe(
        (response) => {
          this.messageService.message(response)
          if (response.status == 200) {
            ExameFisicoService.exameFisicoUpdatedAlert.emit(response)
          }
        }
      )
  }
}
