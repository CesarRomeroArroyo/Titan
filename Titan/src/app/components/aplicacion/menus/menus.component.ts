import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { MenusService } from '../../../services/aplicacion/menus.service';


@Component({
  selector: 'app-menus',
  templateUrl: './menus.component.html',
  styleUrls: ['./menus.component.css']
})
export class MenusComponent implements OnInit {
  dataModal: any = {
    id: '',
      icono: '',
      texto: '',
      accion: '',
      nivel: '',
      estado: '1',
      orden: ''
  };
  modalRef: BsModalRef;
  dataGnrl: any;
  columns: Array<any>;
  numReg: number;

  constructor(private _service: MenusService, private modalService: BsModalService) { }

  ngOnInit() {
    this.obtener();
  }

  obtener() {
    this._service.obtener().subscribe(
      result => {
        this.columns = [
          {title: 'Menu', name: 'texto'},
          {title: 'Accion', name: 'accion'},
          {title: 'Orden', name: 'orden'}
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
      icono: '',
      texto: '',
      accion: '',
      nivel: '',
      estado: '1',
      orden: ''
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
