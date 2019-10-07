import { Component, OnInit } from '@angular/core';
import { AreaDoPaciente } from './area-do-paciente';
import { AreaDoPacienteService } from './area-do-paciente.service';
import { MessageService } from '../../services/messages/message.service';
import { NgxSmartModalService } from 'ngx-smart-modal';

@Component({
  selector: 'app-area-do-paciente',
  templateUrl: './area-do-paciente.component.html',
  styleUrls: ['../../auth/login/login.component.scss']
})

export class AreaDoPacienteComponent implements OnInit {

  public historico: any;
  public hasHistorico: boolean = false;
  public exames: any;
  public hasExame: boolean = false;
  public evolucoes: any;
  public hasEvolucao: boolean = false;

  public form: any = new AreaDoPaciente();
  public modal: string = 'prontuarioModal';

  constructor(
    private areaDoPacienteService: AreaDoPacienteService,
    private messageService: MessageService,
    public ngxSmartModalService: NgxSmartModalService,
  ) { }

  ngOnInit() {
  }

  getDataFromPacienteArea() {
    let date = this.form.data_nascimento.split('/')
    this.form.data_nascimento = date[2] + '-' + date[1] + '-' + date[0]

    this.areaDoPacienteService.getProntuario(this.form)
      .subscribe(response => {
        console.log(response)
        this.messageService.message(response)
        this.form = response.data.paciente[0]
        if (response.data.historico.length > 0) {
          this.historico = response.data.historico[0]
          this.hasHistorico = true
        } else {
          this.hasHistorico = false
        }
        if (response.data.exames.length > 0) {
          this.exames = response.data.exames
          this.hasExame = true
        } else {
          this.hasExame = false
        }
        if (response.data.evolucoes.length > 0) {
          this.evolucoes = response.data.evolucoes
          this.hasEvolucao = true
        } else {
          this.hasEvolucao = false
        }
        this.form.nome_contato = response.data.paciente[0].nome_contato
        this.form.numero_contato = response.data.paciente[0].numero_contato
        if (response.status == 200) {
          this.ngxSmartModalService.open(this.modal)
        }
      })
    this.form.data_nascimento = date

  }

  close() {
    this.eraseForm()
    this.exames = null
    this.evolucoes = null
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.form = {}
  }

}
