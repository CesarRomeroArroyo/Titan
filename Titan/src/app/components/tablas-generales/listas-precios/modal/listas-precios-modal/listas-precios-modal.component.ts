import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { ListasPreciosService } from '../../../../../services/generales/listas-precios.service';

@Component({
  selector: 'app-listas-precios-modal',
  templateUrl: './listas-precios-modal.component.html',
  styleUrls: ['./listas-precios-modal.component.css']
})
export class ListasPreciosModalComponent implements OnInit, OnChanges {
  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private tipoCuenta: any;
  constructor(private _service: ListasPreciosService) { }

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
