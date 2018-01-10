import { Component, OnInit } from '@angular/core';
import { TipoDocumentoService } from '../../../services/generales/tipo-documento.service';

@Component({
  selector: 'app-tipo-documento',
  templateUrl: './tipo-documento.component.html',
  styleUrls: ['./tipo-documento.component.css']
})
export class TipoDocumentoComponent implements OnInit {
  tipoDocumentos: any;
  columns: Array<any> ;
  constructor(private _tipoDocumentoService: TipoDocumentoService) { }

  ngOnInit() {
    this._tipoDocumentoService.getTipoDocumento().subscribe(
      result => {
        console.log(result);
        /*this.columns = [
          {title: 'Id', name: 'id'},
          {title: 'Nombre', name: 'descrip'},
          {title: 'Prefijo', name: 'prefijo'},
          {title: 'Num. Actual', name: 'n_actual'},
          {title: 'Num. Inicial', name: 'n_inicial'},
          {title: 'Num.  Final', name: 'n_final'}
        ];
        this.tipoDocumentos = result;*/
      },
      error => {
          console.log(<any>error);
      }
    );
  }

}
