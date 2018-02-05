import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';


@Injectable()
export class AdministracionTercerosService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  getTerceros(): Observable<any>  {
      return this.http.get(`${this.appSettings.endPointTitan}general_third/`);
  }

  setTercero(tercero: any): Observable<any>  {
      return this.http.post(`${this.appSettings.endPointTitan}general_third/`, tercero);
  }

  updateTercero(tercero: any): Observable<any>  {
      return this.http.put(`${this.appSettings.endPointTitan}general_third/${tercero.idunico}`, tercero);
  }

  deleteTercero(tercero: any): Observable<any>  {
      return this.http.delete(`${this.appSettings.endPointTitan}general_third/${tercero.idunico}`, tercero);
  }

}
