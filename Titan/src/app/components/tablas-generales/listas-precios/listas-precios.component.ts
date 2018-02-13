import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { ListasPreciosService } from '../../../services/generales/listas-precios.service';

@Component({
  selector: 'app-listas-precios',
  templateUrl: './listas-precios.component.html',
  styleUrls: ['./listas-precios.component.css']
})
export class ListasPreciosComponent implements OnInit {
  dataComponent: any = {
    id: '',
    nombre: '',
    margen: ''
  };
  modalRef: BsModalRef;
  dataGrl: any;
  columns: Array<any>;
  numReg: number;

  constructor(private modalService: BsModalService, private _service: ListasPreciosService) { }

  ngOnInit() {
    this.buscarDatos ();
  }

  buscarDatos () {
    this._service.obtener().subscribe(
      result => {
        this.columns = [
          {title: 'Nombre', name: 'nombre'},
          {title: 'Margen', name: 'margen'}
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
      margen: ''
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
