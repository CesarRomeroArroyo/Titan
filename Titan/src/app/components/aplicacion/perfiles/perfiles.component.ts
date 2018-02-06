import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { PerfilesService } from '../../../services/aplicacion/perfiles.service';



@Component({
  selector: 'app-perfiles',
  templateUrl: './perfiles.component.html',
  styleUrls: ['./perfiles.component.css']
})
export class PerfilesComponent implements OnInit {
  dataModal: any = {
    id: '',
    nombre: '',
    estado: ''
  };
  modalRef: BsModalRef;
  dataGnrl: any;
  columns: Array<any>;
  numReg: number;

  constructor(private _service: PerfilesService, private modalService: BsModalService) { }

  ngOnInit() {
    this.obtener();
  }

  obtener() {
    this._service.obtener().subscribe(
      result => {
        this.columns = [
          {title: 'Nombre', name: 'nombre'}
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
      nombre: '',
      estado: '1'
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
