import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { UsuariosService } from '../../../../../services/aplicacion/usuarios.service';

@Component({
  selector: 'app-modal-usuarios',
  templateUrl: './modal-usuarios.component.html',
  styleUrls: ['./modal-usuarios.component.css']
})
export class ModalUsuariosComponent implements OnInit, OnChanges {

  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private itemsEstado: any;
  constructor(private _service: UsuariosService) { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
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
