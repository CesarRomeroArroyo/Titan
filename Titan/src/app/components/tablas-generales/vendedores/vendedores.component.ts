import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import {
    AdministracionTercerosService
} from '../../../services/terceros/administracion-terceros.service';


@Component({
  selector: 'app-vendedores',
  templateUrl: './vendedores.component.html',
  styleUrls: ['./vendedores.component.css']
})
export class VendedoresComponent implements OnInit {
  dataVendedor: any = {
    raz_soc: '',
    num_ide: '',
    email: '',
    tel_1_sede_pri: '',
    tel_2_sede_pri: '',
    idunico: ''
  };
  modalRef: BsModalRef;
  bancos: any;
  columns: Array<any>;
  numReg: number;
  constructor(private _service: AdministracionTercerosService, private modalService: BsModalService) { }

  ngOnInit() {
  }

  buscarDatos () {
    this._service.getTerceros().subscribe(
      result => {
        this.columns = [
          {title: 'Nombre', name: 'raz_soc'},
          {title: 'Identificacion', name: 'num_ide'},
          {title: 'Email', name: 'email'},
          {title: 'Telefono', name: 'tel_1_sede_pri'},
          {title: 'Telefono 2', name: 'tel_2_sede_pri'}
        ];
        this.bancos = result;
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
    this.dataVendedor = {
      raz_soc: '',
      num_ide: '',
      email: '',
      tel_1_sede_pri: '',
      tel_2_sede_pri: '',
      idunico: ''
    };
  }

  onEdit(data: any) {
    this.dataVendedor = data;
  }

  onDelete(template: TemplateRef<any>, data: any) {
    this.dataVendedor = data;
    this.modalRef = this.modalService.show(template, {class: 'modal-sm'});
  }

  deletedInfo() {
    this._service.deleteTercero(this.dataVendedor).subscribe(
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
    this.buscarDatos();
    this.modalService.hide(1);
  }

}
