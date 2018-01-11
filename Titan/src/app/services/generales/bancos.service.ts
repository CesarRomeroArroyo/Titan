import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class BancosService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  getBancos(): Observable<any>  {
     return this.http.get(`${this.appSettings.endPointTitan}buscarTipoDocumentos/`);
  }

  setBancos(banco: any): Observable<any>  {
     return this.http.post(`${this.appSettings.endPointTitan}agregarBanco/`, banco);
  }

  updateBancos(banco: any): Observable<any>  {
     return this.http.post(`${this.appSettings.endPointTitan}actualizarBanco/`, banco);
  }

  deleteBancos(banco: any): Observable<any>  {
     return this.http.post(`${this.appSettings.endPointTitan}eliminarBanco/`, banco);
  }


}
