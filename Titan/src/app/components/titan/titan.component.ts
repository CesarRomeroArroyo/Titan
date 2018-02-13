import { Component, OnInit, Output, EventEmitter, ViewChild } from '@angular/core';
import { SessionStorageService } from '../../services/shared/session-storage.service';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { TemplateRef } from '@angular/core';

@Component({
  selector: 'app-titan',
  templateUrl: './titan.component.html',
  styleUrls: ['./titan.component.css']
})
export class TitanComponent implements OnInit {
  @ViewChild('templateConfirm') templateConfirm: BsModalRef;
  @Output() logOut= new EventEmitter<any>();
  selectedRow: string;
  tabsOptions: any[]= [{text: 'Inicio', component: 'inicio'}];
  mostrarBodegas: boolean;
  constructor(private _session: SessionStorageService, private modalService: BsModalService) {
    this.mostrarBodegas = false;
  }

  ngOnInit() {
    this.verificarBodega();
  }

  onLogOut() {
    this.logOut.emit();
  }

  createTab($event) {
    this.tabsOptions.push({text: $event.text, component: $event.component});
  }

  setClickedRow (index) {
    this.selectedRow = index;
  }

  closeTab (idx) {
    this.tabsOptions.splice(idx, 1);
  }

  verificarBodega() {
    if (!this._session.obtener('TITAN_BODEGA')) {
      this.mostrarBodegas = true;
    } else {
      this.mostrarBodegas = false;
    }
  }

}
