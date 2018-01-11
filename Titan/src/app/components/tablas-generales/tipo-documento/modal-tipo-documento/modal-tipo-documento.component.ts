import { Component, OnInit, Input, OnChanges, SimpleChanges } from '@angular/core';

@Component({
  selector: 'app-modal-tipo-documento',
  templateUrl: './modal-tipo-documento.component.html',
  styleUrls: ['./modal-tipo-documento.component.css']
})
export class ModalTipoDocumentoComponent implements OnInit, OnChanges {
  @Input() data;
  private dataForm;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.dataForm = this.data;
  }

  onSave() {
    if (this.dataForm.id === '') {
      alert('crear');
    } else {
      alert('actualizar');
    }
  }

}
