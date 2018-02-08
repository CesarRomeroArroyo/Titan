import { PermisosService } from '../../../services/shared/permisos.service';
import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { PerfilesService } from '../../../services/aplicacion/perfiles.service';
import { MenusService } from '../../../services/aplicacion/menus.service';

@Component({
  selector: 'app-permisos',
  templateUrl: './permisos.component.html',
  styleUrls: ['./permisos.component.css']
})
export class PermisosComponent implements OnInit {
  perfiles: any;
  menus: any;
  columns: any;
  dataGnrl: any;
  dataMenu: any;
  perfil: any;
  menu: any;
  numReg: number;
  modalRef: BsModalRef;
  dataModal: any;
  constructor(private _service: PermisosService, private modalService: BsModalService, private _servicePerfil: PerfilesService,
     private _serviceMenu: MenusService ) {
      this.dataGnrl = [];
    }

  ngOnInit() {
    this._servicePerfil.obtener().subscribe(
      result => {
        this.perfiles = result;
      }
    );
  }

  agregarPermisos() {
    const permiso = {menu: this.menu, usuario: this.perfil};
    console.log(this.menu);
    this._service.adicionar(permiso).subscribe(
      result => {
        this.savedInfo();
      }
    );
  }

  buscarPermisos() {
    this._serviceMenu.obtenerMenusPermisos(this.perfil).subscribe(
      result => {
        this.columns = [
          {title: 'Nombre', name: 'texto'}
        ];
        this.dataGnrl = result;
        this._serviceMenu.obtenerMenusSinPermisos(this.perfil).subscribe(
          noPermisos => {
            this.dataMenu = noPermisos;
            console.log(noPermisos);
          }
        );
      }
    );
  }

  onDelete(template: TemplateRef<any>, data: any) {
    this.dataModal = data;
    this.modalRef = this.modalService.show(template, {class: 'modal-sm'});
  }

  deletedInfo() {
    this._service.eliminar(this.dataModal, this.perfil).subscribe(
      result => {
       console.log(result);
       this.savedInfo();
      },
      error => {
          console.log(<any>error);
      }
    );
  }

  savedInfo() {
    this.buscarPermisos();
    this.modalService.hide(1);
  }

}
