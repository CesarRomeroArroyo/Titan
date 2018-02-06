import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { UsuariosService } from '../../../services/aplicacion/usuarios.service';

@Component({
  selector: 'app-usuarios',
  templateUrl: './usuarios.component.html',
  styleUrls: ['./usuarios.component.css']
})
export class UsuariosComponent implements OnInit {
  dataModal: any = {
    id: '',
    usuario: '',
    password: '',
    nombre: '',
    codigo: '',
    email: '',
    fec_ini: '',
    fec_fin: '',
    oficina: ''
  };
  modalRef: BsModalRef;
  dataGnrl: any;
  columns: Array<any>;
  numReg: number;

  constructor(private _service: UsuariosService, private modalService: BsModalService) { }

  ngOnInit() {
    this.obtener();
  }

  obtener() {
    this._service.obtener().subscribe(
      result => {
        this.columns = [
          {title: 'Usuario', name: 'usuario'},
          {title: 'Nombre', name: 'nombre'},
          {title: 'Codigo', name: 'codigo'},
          {title: 'Email', name: 'email'}
        ];
        this.dataGnrl = result;
      },
      error => {
          console.log(<any>error);
      }
    );
  }

  openModal(template: TemplateRef<any>) {
    this.modalRef = this.modalService.show(template, { class: 'modal-lg' });
  }

  onCreate() {
    this.dataModal = {
      id: '',
      usuario: '',
      password: '',
      nombre: '',
      codigo: '',
      email: '',
      fec_ini: '',
      fec_fin: '',
      oficina: ''
    };
  }

  onEdit(data: any) {
    this.dataModal = data;
  }

  onDelete(template: TemplateRef<any>, data: any) {
    this.dataModal = data;
    this.modalRef = this.modalService.show(template, {class: 'modal-sm'});
  }

  deletedInfo() {
    this._service.eliminar(this.dataModal).subscribe(
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
    this.obtener();
    this.modalService.hide(1);
  }


}
