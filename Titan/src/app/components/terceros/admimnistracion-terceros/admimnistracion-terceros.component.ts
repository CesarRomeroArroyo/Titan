import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { AdministracionTercerosService } from '../../../services/terceros/administracion-terceros.service';

@Component({
  selector: 'app-admimnistracion-terceros',
  templateUrl: './admimnistracion-terceros.component.html',
  styleUrls: ['./admimnistracion-terceros.component.css']
})
export class AdmimnistracionTercerosComponent implements OnInit {

  constructor(private _service: AdministracionTercerosService, private modalService: BsModalService) { }
  dataTerceros: any = {
    id: '',
    tip_ide: '',
    num_ide: '',
    dig_cheq: '',
    raz_soc: '',
    nom_rep_leg: '',
    ape_rep_leg: '',
    controlado: '',
    tip_cont: '',
    email: '',
    tipo: '',
    cupo_credito: '',
    listaprecios: '',
    condicion_pago: '',
    vendedor: '',
    descuento: '',
    dir_sede_pri: '',
    ciu_sede_pri: '',
    ruta: '',
    tel_1_sede_pri: '',
    tel_2_sede_pri: '',
    observaciones: ''
  };
  modalRef: BsModalRef;
  tercero: any;
  columns: Array<any>;

  ngOnInit() {
    this._service.getTerceros().subscribe(
      result => {
        console.log(result);
        this.columns = [
          {title: 'Tipo', name: 'tipo'},
          {title: 'Nit', name: 'num_ide'},
          {title: 'Razon Social', name: 'raz_soc'},
          {title: 'Direccion', name: 'dir_sede_pri'},
          {title: 'Estado', name: 'codigo'}
        ];
        this.tercero = result;
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
    this.dataTerceros = {
      id: '',
      tip_ide: '',
      num_ide: '',
      dig_cheq: '',
      raz_soc: '',
      nom_rep_leg: '',
      ape_rep_leg: '',
      controlado: '',
      tip_cont: '',
      email: '',
      tipo: '',
      cupo_credito: '',
      listaprecios: '',
      condicion_pago: '',
      vendedor: '',
      descuento: '',
      dir_sede_pri: '',
      ciu_sede_pri: '',
      ruta: '',
      tel_1_sede_pri: '',
      tel_2_sede_pri: '',
      observaciones: ''
    };
  }

  onEdit(data: any) {
    this.dataTerceros = data;
    console.log(this.dataTerceros);
  }
}
