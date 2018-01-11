import { Component, OnInit, Input, OnChanges, SimpleChanges } from '@angular/core';
import { BancosService } from '../../../../services/generales/bancos.service';
@Component({
  selector: 'app-modal-bancos',
  templateUrl: './modal-bancos.component.html',
  styleUrls: ['./modal-bancos.component.css']
})
export class ModalBancosComponent implements OnInit, OnChanges {
  @Input() data;
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
    if (this.dataForm.id === '') {
      const retorno = this._service.setBancos(this.dataForm).subscribe(
        result => {
         console.log(result);
        },
        error => {
            console.log(<any>error);
        }
      );
      console.log(retorno);
    } else {
      this._service.updateBancos(this.dataForm);
    }
  }
}
