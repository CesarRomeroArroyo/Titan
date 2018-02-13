import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { CondicionPagoService } from '../../../../../services/generales/condicion-pago.service';


@Component({
  selector: 'app-formas-pago-modal',
  templateUrl: './formas-pago-modal.component.html',
  styleUrls: ['./formas-pago-modal.component.css']
})
export class FormasPagoModalComponent implements OnInit, OnChanges {
  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private tipoCuenta: any;
  constructor(private _service: CondicionPagoService) { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
  }

  onSave() {
    if (this.dataForm.id === '') {
      const retorno = this._service.insertar(this.dataForm).subscribe(
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
      this._service.actualizar(this.dataForm).subscribe(
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
