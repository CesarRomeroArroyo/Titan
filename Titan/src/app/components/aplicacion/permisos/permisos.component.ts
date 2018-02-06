import { PermisosService } from '../../../services/shared/permisos.service';
import { Component, OnInit } from '@angular/core';
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
  constructor(private _service: PermisosService, private modalService: BsModalService, private _servicePerfil: PerfilesService,
     private serviceMenu: MenusService ) { }

  ngOnInit() {
    this._servicePerfil.obtener().subscribe(
      result => {
        this.perfiles = result;
        console.log(this.perfiles);
      }
    );
  }

  buscarPermisos() {

  }

}
