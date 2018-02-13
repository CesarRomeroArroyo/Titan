import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class TipoDocumentoService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  getTipoDocumento(): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}General_Documentos/`);
    return retorno;
  }

  setTipoDocumento(tipoDoc: any): Observable<any>  {
    return this.http.post(`${this.appSettings.endPointTitan}General_Documentos/`, tipoDoc);
 }


  updateTipoDocumento(tipoDoc: any): Observable<any>  {
    return this.http.put(`${this.appSettings.endPointTitan}General_Documentos/${tipoDoc.id}`, tipoDoc);
 }

 deleteTipoDocumento(tipoDoc: any): Observable<any>  {
    return this.http.delete(`${this.appSettings.endPointTitan}General_Documentos/${tipoDoc.id}`);
  }
}
