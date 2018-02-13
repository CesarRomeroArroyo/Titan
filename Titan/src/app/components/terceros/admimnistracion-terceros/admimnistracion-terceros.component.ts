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
      razon_soc: '',
      tip_ide: '',
      num_ide: '',
      pri_nom_rep_leg: '',
      seg_nom_rep_leg: '',
      pri_ape__rep_leg: '',
      seg_ape_rep_leg: '',
      tip_doc_rep_leg: '',
      num_doc_rep_leg: '',
      tipo_contribuyente: '',
      reg_camara_comercio: '',
      fec_const: '',
      ciudad_const: '',
      ruta: '',
      cod_actividad: '',
      tip_proveedor: '',
      proveedor_de: '',
      banco: '',
      direccion: '',
      barrio: '',
      ciudad: '',
      telefono: '',
      telefono2: '',
      fax: '',
      cod_postal: '',
      email: '',
      web: '',
      tip_ref: '',
      nombre_ref: '',
      tip_ide_ref: '',
      num_ide_ref: '',
      tel_ref: '',
      email_ref: '',
      condicion_pago: '',
      forma_pago: '',
      autoretenedor: '',
      vendedor: '',
      cupo_credito: '',
      disponible: '',
      disponible_monto: '',
      saldo_cartera: '',
      pendientes: '',
      tipo_pendientes: '',
      descuento: '',
      listaprecios: '',
      copias_factura: '',
      observaciones: '',
      tipo: '',
      estado: ''
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
      razon_soc: '',
      tip_ide: '',
      num_ide: '',
      pri_nom_rep_leg: '',
      seg_nom_rep_leg: '',
      pri_ape__rep_leg: '',
      seg_ape_rep_leg: '',
      tip_doc_rep_leg: '',
      num_doc_rep_leg: '',
      tipo_contribuyente: '',
      reg_camara_comercio: '',
      fec_const: '',
      ciudad_const: '',
      ruta: '',
      cod_actividad: '',
      tip_proveedor: '',
      proveedor_de: '',
      banco: '',
      direccion: '',
      barrio: '',
      ciudad: '',
      telefono: '',
      telefono2: '',
      fax: '',
      cod_postal: '',
      email: '',
      web: '',
      tip_ref: '',
      nombre_ref: '',
      tip_ide_ref: '',
      num_ide_ref: '',
      tel_ref: '',
      email_ref: '',
      condicion_pago: '',
      forma_pago: '',
      autoretenedor: '',
      vendedor: '',
      cupo_credito: '',
      disponible: '',
      disponible_monto: '',
      saldo_cartera: '',
      pendientes: '',
      tipo_pendientes: '',
      descuento: '',
      listaprecios: '',
      copias_factura: '',
      observaciones: '',
      tipo: '',
      estado: ''
    };
  }

  onEdit(data: any) {
    this.dataTerceros = data;
    console.log(this.dataTerceros);
  }
}
