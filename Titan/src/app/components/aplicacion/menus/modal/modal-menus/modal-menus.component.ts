import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { MenusService } from '../../../../../services/aplicacion/menus.service';

@Component({
  selector: 'app-modal-menus',
  templateUrl: './modal-menus.component.html',
  styleUrls: ['./modal-menus.component.css']
})
export class ModalMenusComponent implements OnInit, OnChanges {

  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  private itemsEstado: any;
  private menuPrincpales: any;
  constructor(private _service: MenusService) { }

  ngOnInit() {
    this._service.obtenerPrincipales().subscribe(
      result => {
        this.menuPrincpales = result;
      }
    );
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
    this.dataForm.estado = this.dataForm.estado;
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
