import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { PerfilesService } from '../../../services/aplicacion/perfiles.service';
import { MenusService } from '../../../services/aplicacion/menus.service';
import { UsuariosService } from '../../../services/aplicacion/usuarios.service';
import { PermisosService } from '../../../services/shared/permisos.service';

@Component({
  selector: 'app-asignar-perfil',
  templateUrl: './asignar-perfil.component.html',
  styleUrls: ['./asignar-perfil.component.css']
})
export class AsignarPerfilComponent implements OnInit {
  usuario: any;
  usuarios: any;
  perfil: any;
  perfilSel: any;
  perfiles: any;

  constructor(private modalService: BsModalService, private _servicePerfil: PerfilesService,
    private _serviceMenu: MenusService, private _serviceUsuario: UsuariosService,
    private _permisosService: PermisosService ) { }

  ngOnInit() {
    this.buscarPerfiles();
    this.buscarUsuarios();
  }

  buscarPerfil() {
    this._permisosService.buscarPerfilUsuarioCodigo(this.usuario).subscribe(
      result => {
        this.perfil = result;
        this.perfilSel = result.perfil;
        console.log(this.perfil);
      }
    );
  }

  buscarPerfiles() {
    this._servicePerfil.obtener().subscribe(
      resultPer => {
        this.perfiles = resultPer;
      }
    );
  }

  buscarUsuarios() {
    this._serviceUsuario.obtener().subscribe(
      resultUser => {
        this.usuarios = resultUser;
      }
    );
  }

  cambiarUsuario() {
    this.buscarPerfil();
    console.log(this.usuario);
  }

  asignarPerfil() {
    this.perfil.perfil = this.perfilSel;
    this._permisosService.actualizarPerfil(this.perfil).subscribe(
      result => {
        console.log(result);
      }
    );
  }
}
