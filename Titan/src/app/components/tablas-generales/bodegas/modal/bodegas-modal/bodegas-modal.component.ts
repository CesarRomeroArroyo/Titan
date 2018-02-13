import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { BodegasService } from '../../../../../services/generales/bodegas.service';


@Component({
  selector: 'app-bodegas-modal',
  templateUrl: './bodegas-modal.component.html',
  styleUrls: ['./bodegas-modal.component.css']
})
export class BodegasModalComponent implements OnInit, OnChanges {
  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private tipoCuenta: any;
  constructor(private _service: BodegasService) { }

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
