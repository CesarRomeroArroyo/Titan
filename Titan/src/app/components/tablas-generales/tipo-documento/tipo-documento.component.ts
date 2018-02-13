import { Component, OnInit, TemplateRef } from '@angular/core';
import { TipoDocumentoService } from '../../../services/generales/tipo-documento.service';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import {  } from '@angular/core';


@Component({
  selector: 'app-tipo-documento',
  templateUrl: './tipo-documento.component.html',
  styleUrls: ['./tipo-documento.component.css']
})
export class TipoDocumentoComponent implements OnInit {
  dataTipoDoc: any = {
    id: '', idbodega: '', idalmacen: '', num_resolucion: '', fec_resolucion: '', descripcion: '', notas: '', prefijo: '',
    n_actual: '', n_final: '', n_inicial: ''};
  modalRef: BsModalRef;
  tipoDocumentos: any;
  columns: Array<any> ;


  constructor(private _tipoDocumentoService: TipoDocumentoService, private modalService: BsModalService) { }

  ngOnInit() {
    this.buscarDatos();
  }

  buscarDatos() {
    this._tipoDocumentoService.getTipoDocumento().subscribe(
      result => {
        this.columns = [
          {title: 'Nombre', name: 'descripcion'},
          {title: 'Prefijo', name: 'prefijo'},
          {title: 'Num. Actual', name: 'n_actual'},
          {title: 'Num. Inicial', name: 'n_inicial'},
          {title: 'Num.  Final', name: 'n_final'}
        ];
        this.tipoDocumentos = result;
      },
      error => {
          console.log(<any>error);
      }
    );
  }

  openModal(template: TemplateRef<any>) {
    this.modalRef = this.modalService.show(template);
  }
  onCreate() {
    this.dataTipoDoc = {id: '', idbodega: '', idalmacen: '', num_resolucion: '', fec_resolucion: '', descripcion: '',
                        notas: '', prefijo: '', n_actual: '', n_final: '', n_inicial: ''};
  }

  onEdit(data: any) {
    this.dataTipoDoc = data;
  }

  onDelete(template: TemplateRef<any>, data: any) {
    this.dataTipoDoc = data;
    this.modalRef = this.modalService.show(template, {class: 'modal-sm'});
  }

  deletedInfo() {
    this._tipoDocumentoService.deleteTipoDocumento(this.dataTipoDoc).subscribe(
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
