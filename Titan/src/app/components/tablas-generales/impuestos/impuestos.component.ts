import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { ImpuestosService } from '../../../services/generales/impuestos.service';


@Component({
  selector: 'app-impuestos',
  templateUrl: './impuestos.component.html',
  styleUrls: ['./impuestos.component.css']
})
export class ImpuestosComponent implements OnInit {

  dataComponent: any = {
    id: '',
    nombre: '',
    porcentaje: '',
    marca : '',
    estado: '1'
  };
  modalRef: BsModalRef;
  dataGrl: any;
  columns: Array<any>;
  numReg: number;
  constructor(private modalService: BsModalService, private _service: ImpuestosService) { }

  ngOnInit() {
    this.buscarDatos ();
  }

  buscarDatos () {
    this._service.obtener().subscribe(
      result => {
        this.columns = [
          {title: 'Nombre', name: 'nombre'},
          {title: 'Porcentaje', name: 'porcentaje'},
          {title: 'Marca', name: 'marca'}
        ];
        this.dataGrl = result;
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
    this.dataComponent = {
      id: '',
      nombre: '',
      porcentaje: '',
      marca : '',
      estado: '1'
    };
  }

  onEdit(data: any) {
    this.dataComponent = data;
  }

  onDelete(template: TemplateRef<any>, data: any) {
    this.dataComponent = data;
    this.modalRef = this.modalService.show(template, {class: 'modal-sm'});
  }

  deletedInfo() {
    this._service.eliminar(this.dataComponent).subscribe(
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
