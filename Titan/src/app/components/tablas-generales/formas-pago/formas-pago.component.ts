import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { CondicionPagoService } from '../../../services/generales/condicion-pago.service';

@Component({
  selector: 'app-formas-pago',
  templateUrl: './formas-pago.component.html',
  styleUrls: ['./formas-pago.component.css']
})
export class FormasPagoComponent implements OnInit {
  dataComponent: any = {
    id: '',
    descripcion: '',
    plazo: '',
    interes_1: '',
    plazo_2: '',
    interes_2: '',
    diagracia: '',
    desc_pronto_pago: '',
    notas: ''
  };
  modalRef: BsModalRef;
  dataGrl: any;
  columns: Array<any>;
  numReg: number;
  constructor(private modalService: BsModalService, private _service: CondicionPagoService) { }

  ngOnInit() {
    this.buscarDatos ();
  }

  buscarDatos () {
    this._service.obtener().subscribe(
      result => {
        this.columns = [
          {title: 'Descripcion', name: 'descripcion'},
          {title: 'Plazo', name: 'plazo'}
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
      plazo: '',
      interes_1: '',
      plazo_2: '',
      interes_2: '',
      diagracia: '',
      desc_pronto_pago: '',
      notas: ''
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
