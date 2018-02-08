import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class MenusService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  obtener(): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}General_Menu/`);
     return retorno;
  }

  obtenerPrincipales(): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}General_Menu/Principales/`);
     return retorno;
  }

  obtenerMenusPermisos(id: string): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}General_Menu/MenusPermisos/?id=${id}`);
     return retorno;
  }

  obtenerMenusSinPermisos(id: string): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}General_Menu/MenusSinPermisos/?id=${id}`);
     return retorno;
  }

  adicionar(datos: any): Observable<any>  {
     return this.http.post(`${this.appSettings.endPointTitan}General_Menu/`, datos);
  }

  actualizar(datos: any): Observable<any>  {
     return this.http.put(`${this.appSettings.endPointTitan}General_Menu/${datos.id}`, datos);
  }

  eliminar(datos: any): Observable<any>  {
     return this.http.delete(`${this.appSettings.endPointTitan}General_Menu/${datos.id}`);
  }
}
