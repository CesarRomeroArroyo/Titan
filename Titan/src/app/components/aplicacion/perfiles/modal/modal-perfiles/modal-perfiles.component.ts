import { PerfilesService } from '../../../../../services/aplicacion/perfiles.service';
import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';

@Component({
  selector: 'app-modal-perfiles',
  templateUrl: './modal-perfiles.component.html',
  styleUrls: ['./modal-perfiles.component.css']
})
export class ModalPerfilesComponent implements OnInit, OnChanges {
  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private itemsEstado: any;
  constructor(private _service: PerfilesService) { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
    this.dataForm.estado = this.dataForm.estado.toString();
    this.itemsEstado = [{id: '1', value: 'Activo'}, {id: '2', value: 'Inactivo'}];
  }

  onSave() {
    if (this.dataForm.id === '') {
      const retorno = this._service.adicionar(this.dataForm).subscribe(
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
