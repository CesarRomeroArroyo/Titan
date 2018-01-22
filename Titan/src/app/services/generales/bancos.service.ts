import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class BancosService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  getBancos(): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}general_bancos/`);
     return retorno;
  }

  setBancos(banco: any): Observable<any>  {
     return this.http.post(`${this.appSettings.endPointTitan}general_bancos/`, banco);
  }

  updateBancos(banco: any): Observable<any>  {
     return this.http.put(`${this.appSettings.endPointTitan}general_bancos/`, banco);
  }

  deleteBancos(banco: any): Observable<any>  {
     return this.http.delete(`${this.appSettings.endPointTitan}general_bancos/`, banco);
  }
}
