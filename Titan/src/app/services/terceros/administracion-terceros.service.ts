import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';


@Injectable()
export class AdministracionTercerosService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  getTerceros(): Observable<any>  {
    return this.http.get(`${this.appSettings.endPointTitan}buscarTerceros/`);
 }

 setTercero(banco: any): Observable<any>  {
    return this.http.post(`${this.appSettings.endPointTitan}agregarBanco/`, banco);
 }

 updateTercero(banco: any): Observable<any>  {
    return this.http.post(`${this.appSettings.endPointTitan}actualizarBanco/`, banco);
 }

 deleteTercero(banco: any): Observable<any>  {
    return this.http.post(`${this.appSettings.endPointTitan}eliminarBanco/`, banco);
 }

}
