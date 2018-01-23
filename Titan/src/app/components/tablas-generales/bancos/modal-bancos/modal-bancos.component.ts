import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { BancosService } from '../../../../services/generales/bancos.service';

@Component({
  selector: 'app-modal-bancos',
  templateUrl: './modal-bancos.component.html',
  styleUrls: ['./modal-bancos.component.css']
})
export class ModalBancosComponent implements OnInit, OnChanges {
  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private tipoCuenta: any;
  constructor(private _service: BancosService) {
    this.tipoCuenta = [{id: '1', value: 'AHORRO'}, {id: '2', value: 'CORRIENTE'}];
  }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
  }

  onSave() {
    if (this.dataForm.idunico === '') {
      const retorno = this._service.setBancos(this.dataForm).subscribe(
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
      this._service.updateBancos(this.dataForm).subscribe(
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
