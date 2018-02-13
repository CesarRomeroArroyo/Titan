import { Component, OnInit, Output, EventEmitter} from '@angular/core';
import { BodegasService } from '../../../services/generales/bodegas.service';
import { SessionStorageService } from '../../../services/shared/session-storage.service';

@Component({
  selector: 'app-bodega-modal',
  templateUrl: './bodega-modal.component.html',
  styleUrls: ['./bodega-modal.component.css']
})
export class BodegaModalComponent implements OnInit {
  @Output() bodegaSeleccionada = new EventEmitter<void>();
  bodegas: any = [];
  bodegaSel: string;
  constructor(private _service: BodegasService, private _session: SessionStorageService) { }

  ngOnInit() {
      this._service.obtener().subscribe(
        result => {
          this.bodegas = result;
        }
      );
  }

  seleccionarBodega() {
    this._session.agregar('TITAN_BODEGA', this.bodegaSel);
    this.bodegaSeleccionada.emit();
  }

}
