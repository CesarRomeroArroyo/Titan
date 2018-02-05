import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import {
    AdministracionTercerosService
} from '../../../../services/terceros/administracion-terceros.service';

@Component({
  selector: 'app-modal-vendedores',
  templateUrl: './modal-vendedores.component.html',
  styleUrls: ['./modal-vendedores.component.css']
})
export class ModalVendedoresComponent implements OnInit, OnChanges {
  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private tipoCuenta: any;
  constructor(private _service: AdministracionTercerosService) { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
  }

  onSave() {
    if (this.dataForm.idunico === '') {
      const retorno = this._service.setTercero(this.dataForm).subscribe(
        result => {
         console.log(result);
         this.savedEvent.emit();
        },
        error => {
            console.log(<any>error);
        }
      );
      console.log(retorno);
    } else {
      this._service.updateTercero(this.dataForm).subscribe(
        result => {
         console.log(result);
         this.savedEvent.emit();
        },
        error => {
            console.log(<any>error);
        }
      );
    }
  }


}
