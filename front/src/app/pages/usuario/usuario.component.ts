import { Component, OnInit } from '@angular/core';

import { Usuario } from './usuario';
import { UsuarioService } from './usuario.service';
import { NgxSmartModalService } from 'ngx-smart-modal';
import { HelperService } from '../../helper/helper.service';
import { environment } from '../../../environments/environment';
import { DatatablesComponent } from '../../shared/datatables/datatables.component';

@Component({
  selector: 'app-usuario',
  templateUrl: './usuario.component.html',
  styleUrls: ['./usuario.component.scss']
})
export class UsuarioComponent extends DatatablesComponent implements OnInit {

  public _perfis: any[];

  public form: any = new Usuario();
  public modal = 'usuarioModal';
  public modalResetPassword = 'resetPasswordModal';
  public usuarios: any[];
  public isNewUsuario: boolean = true;

  constructor
    (
      private usuarioService: UsuarioService,
      public ngxSmartModalService: NgxSmartModalService,
      private helperService: HelperService,
  ) {
    super();
    console.log('UsuarioComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.dtOptions.order = [0, 'asc']
    this.getUsuarios()
  }

  getUsuarios(): any {
    this.usuarioService.getUsuarios()
      .subscribe(response => {
        this.usuarios = response.usuarios.map(function (usuario) {
          if (usuario.name != 'Alexi') {
            return usuario
          }
        })
        this.usuarios = this.helperService.filterArray(this.usuarios)
        this._perfis = response.perfis
        this.rerenderTable()
      })
  }

  save() {
    console.log(this.form)
    this.saveUsuario()
    UsuarioService.usuarioCreatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getUsuarios()
        this.close()
        UsuarioService.usuarioCreatedAlert.isStopped = true
      }
    )
  }

  saveUsuario() {
    this.usuarioService.postUsuario(this.form)
  }

  openFormEdit(id) {
    this.isNewUsuario = false
    this.usuarioService.getUsuarioById(id)
      .subscribe(response => {
        console.log(response)
        this.form = response
      })
    this.ngxSmartModalService.open(this.modal)
  }


  update() {
    console.log(this.form)
    this.updateUsuario()
    UsuarioService.usuarioUpdatedAlert.subscribe(
      () => {
        this.eraseForm()
        this.getUsuarios()
        this.close()
        UsuarioService.usuarioUpdatedAlert.isStopped = true
      }
    )

  }

  updateUsuario() {
    this.usuarioService.updateUsuario(this.form)
  }

  close() {
    this.isNewUsuario = true
    this.eraseForm()
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.form = {}
    this.isNewUsuario = true
  }

  eraseField(perfil) {
    if (perfil == 3) {
      delete this.form.crm
    }
    if (perfil == 4) {
      delete this.form.coren
    }
  }

  openFormresetPassword(id) {
    this.isNewUsuario = false
    this.usuarioService.getUsuarioById(id)
      .subscribe(response => {
        console.log(response)
        this.form = response
      })
    this.ngxSmartModalService.open(this.modalResetPassword)
  }

  resetPassword() {
    this.usuarioService.resetPasswordUsuario(this.form)
    UsuarioService.usuarioUpdatedAlert.subscribe(
      () => {
        this.getUsuarios()
        this.closeResetPassword()
        UsuarioService.usuarioUpdatedAlert.isStopped = true
      }
    )
  }

  closeResetPassword() {
    this.eraseForm()
    this.ngxSmartModalService.close(this.modalResetPassword)
  }


}
