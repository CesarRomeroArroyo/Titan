import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { ImpuestosService } from '../../../../../services/generales/impuestos.service';

@Component({
  selector: 'app-impuestos-modal',
  templateUrl: './impuestos-modal.component.html',
  styleUrls: ['./impuestos-modal.component.css']
})
export class ImpuestosModalComponent implements OnInit, OnChanges {

  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private tipoCuenta: any;
  constructor(private _service: ImpuestosService) {
   }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
  }

  onSave() {
    if (this.dataForm.id === '') {
      this.dataForm.codigo = this.dataForm.codigo;
      this.dataForm.cuenta = this.dataForm.cuenta;
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
