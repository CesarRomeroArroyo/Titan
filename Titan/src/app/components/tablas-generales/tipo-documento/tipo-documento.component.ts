import { Component, OnInit, TemplateRef } from '@angular/core';
import { TipoDocumentoService } from '../../../services/generales/tipo-documento.service';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';


@Component({
  selector: 'app-tipo-documento',
  templateUrl: './tipo-documento.component.html',
  styleUrls: ['./tipo-documento.component.css']
})
export class TipoDocumentoComponent implements OnInit {
  dataTipoDoc: any = {comportamiento: '', convertir: '', descrip: '', formato_imp: '', id: '', id_bodega: '', n_actual: '', n_final: '', n_inicial: '', notas: '', prefijo: ''};
  modalRef: BsModalRef;
  tipoDocumentos: any;
  columns: Array<any> ;
  constructor(private _tipoDocumentoService: TipoDocumentoService, private modalService: BsModalService) { }

  ngOnInit() {
    this._tipoDocumentoService.getTipoDocumento().subscribe(
      result => {
        this.columns = [
          {title: 'Id', name: 'id'},
          {title: 'Nombre', name: 'descrip'},
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
    this.dataTipoDoc = {comportamiento: '', convertir: '', descrip: '', formato_imp: '', id: '', id_bodega: '', n_actual: '', n_final: '', n_inicial: '', notas: '', prefijo: ''};
  }

  onEdit(data: any) {
    this.dataTipoDoc = data;
  }
}
