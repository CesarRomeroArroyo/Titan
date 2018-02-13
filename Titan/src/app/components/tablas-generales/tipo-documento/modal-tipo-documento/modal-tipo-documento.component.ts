import { TipoDocumentoService } from '../../../../services/generales/tipo-documento.service';
import { Component, OnInit, Input, Output, OnChanges, SimpleChanges, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal-tipo-documento',
  templateUrl: './modal-tipo-documento.component.html',
  styleUrls: ['./modal-tipo-documento.component.css']
})
export class ModalTipoDocumentoComponent implements OnInit, OnChanges {
  @Input() data;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  constructor(private _tipoDocumentoService: TipoDocumentoService) { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
  }

  onSave() {
    if (this.dataForm.id === '') {
      this._tipoDocumentoService.setTipoDocumento(this.dataForm).subscribe(
        result => {
         console.log(result);
         this.savedEvent.emit();
        },
        error => {
            console.log(<any>error);
        }
      );
    } else {
      this._tipoDocumentoService.updateTipoDocumento(this.dataForm).subscribe(
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
