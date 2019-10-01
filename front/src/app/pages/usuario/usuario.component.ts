import { Component, OnInit } from '@angular/core';
import { Usuario } from './usuario';
import { UsuarioService } from './usuario.service';
import { environment } from '../../../environments/environment';
import { NgxSmartModalService } from 'ngx-smart-modal';
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
  public usuarios: any[];
  public isNewUsuario: boolean = true;

  constructor
    (
      private usuarioService: UsuarioService,
      public ngxSmartModalService: NgxSmartModalService
    ) {
    super();
    console.log('UsuarioComponent')
  }

  ngOnInit() {
    this.dtOptions = environment.dtOptions
    this.getUsuarios()
  }

  getUsuarios(): any {
    this.usuarioService.getUsuarios()
      .subscribe(response => {
        this.usuarios = response
      })
  }

  save() {
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

  // openFormEdit(id) {
  //   this.isNewItem = false
  //   this.inventarioService.getItemById(id)
  //     .subscribe(response => {
  //       this.form = response
  //     })
  //   this.ngxSmartModalService.open(this.modal)
  // }


  // update() {
  //   this.updateItem()
  //   InventarioService.itemUpdatedAlert.subscribe(
  //     () => {
  //       this.eraseForm()
  //       this.getItens()
  //       this.close()
  //       InventarioService.itemUpdatedAlert.isStopped = true
  //     }
  //   )

  // }

  // updateItem() {
  //   this.inventarioService.updateItem(this.form)
  // }

  close() {
    this.isNewUsuario = true
    this.eraseForm()
    this.ngxSmartModalService.close(this.modal)
  }

  eraseForm() {
    this.form = {}
  }

}
