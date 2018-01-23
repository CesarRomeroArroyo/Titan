import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { BancosService } from '../../../services/generales/bancos.service';

@Component({
  selector: 'app-bancos',
  templateUrl: './bancos.component.html',
  styleUrls: ['./bancos.component.css']
})
export class BancosComponent implements OnInit {
  dataBancos: any = {
    id: '',
    codigo: '',
    nombre: '',
    descripcion: '',
    cuenta: '',
    tipocuenta: '',
    direccion: '',
    telefono: '',
    contacto: ''
  };
  modalRef: BsModalRef;
  bancos: any;
  columns: Array<any>;
  numReg: number;
  constructor(private _service: BancosService, private modalService: BsModalService) { }

  ngOnInit() {
    this.buscarDatos();
  }

  buscarDatos () {
    this._service.getBancos().subscribe(
      result => {
        this.columns = [
          {title: 'Cuenta', name: 'cuenta'},
          {title: 'Nombre', name: 'nombre'},
          {title: 'Codigo', name: 'codigo'}
        ];
        this.bancos = result;
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
    this.dataBancos = {
      id: this.bancos.length,
      codigo: '',
      nombre: '',
      descripcion: '',
      cuenta: '',
      tipocuenta: '',
      direccion: '',
      telefono: '',
      contacto: '',
      idunico: ''
    };
  }

  onEdit(data: any) {
    this.dataBancos = data;
  }

  onDelete(data: any) {
    this._service.deleteBancos(data).subscribe(
      result => {
       console.log(result);
       this.buscarDatos();
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
