import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { BodegasService } from '../../../services/generales/bodegas.service';


@Component({
  selector: 'app-bodegas',
  templateUrl: './bodegas.component.html',
  styleUrls: ['./bodegas.component.css']
})
export class BodegasComponent implements OnInit {
  dataComponent: any = {
    id: '',
    descripcion: '',
    direccion: '',
    telefono: ''
  };
  modalRef: BsModalRef;
  dataGrl: any;
  columns: Array<any>;
  numReg: number;
  constructor(private modalService: BsModalService, private _service: BodegasService) { }

  ngOnInit() {
    this.buscarDatos ();
  }

  buscarDatos () {
    this._service.obtener().subscribe(
      result => {
        this.columns = [
          {title: 'Descripcion', name: 'descripcion'},
          {title: 'Direccion', name: 'direccion'},
          {title: 'Telefono', name: 'telefono'},
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
      descripcion: '',
      direccion: '',
      telefono: ''
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
