import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';

import { environment } from '../../../environments/environment';
import { MessageService } from '../../services/messages/message.service';


@Injectable({
  providedIn: 'root'
})
export class AreaDoPacienteService {

  static prontuarioFindedAlert;

  private areaDoPacienteUrl: string;

  constructor
    (
      private http: HttpClient,
      private messageService: MessageService,
  ) {
    console.log('AreaDoPacienteService')
    this.areaDoPacienteUrl = environment.baseAPI + 'area-do-paciente'
  }

  getProntuario(data: any) {
    return this.http.post<any>(this.areaDoPacienteUrl, data)
    .pipe(map(response => {
      this.messageService.message(response)
      return response.data;
    }))
  }

}
