import { Component, OnInit, TemplateRef } from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';

@Component({
  selector: 'app-listas',
  templateUrl: './listas.component.html',
  styleUrls: ['./listas.component.css']
})
export class ListasComponent implements OnInit {
  llave: string;
  valor: string;
  columns: any;
  dataGnrl: any;
  dataMenu: any;
  numReg: number;
  dataModal: any;
  constructor() {
      this.dataGnrl = [];
  }

  ngOnInit() {

  }

  buscarListas() {

  }
}
