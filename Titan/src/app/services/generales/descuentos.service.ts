import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class DescuentosService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  obtener(): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}General_Descuento/`);
    return retorno;
  }

  insertar(data: any): Observable<any>  {
    return this.http.post(`${this.appSettings.endPointTitan}General_Descuento/`, data);
 }


  actualizar(data: any): Observable<any>  {
    return this.http.put(`${this.appSettings.endPointTitan}General_Descuento/${data.id}`, data);
 }

 eliminar(data: any): Observable<any>  {
    return this.http.delete(`${this.appSettings.endPointTitan}General_Descuento/${data.id}`);
  }

}
