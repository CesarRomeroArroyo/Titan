import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class TipoDocumentoService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  getTipoDocumento(): Observable<any>  {
     return this.http.get(`${this.appSettings.endPointTitan}buscarTipoDocumentos/`);
  }
}
