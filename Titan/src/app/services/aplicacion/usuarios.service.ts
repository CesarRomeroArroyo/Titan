import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
@Injectable()
export class UsuariosService {

  constructor(private appSettings: AppSettings, private http: HttpClient) { }

  obtener(): Observable<any>  {
    const retorno = this.http.get(`${this.appSettings.endPointTitan}General_Usuarios/`);
     return retorno;
  }

  adicionar(datos: any): Observable<any>  {
     return this.http.post(`${this.appSettings.endPointTitan}General_Usuarios/`, datos);
  }

  actualizar(datos: any): Observable<any>  {
     return this.http.put(`${this.appSettings.endPointTitan}General_Usuarios/${datos.id}`, datos);
  }

  eliminar(datos: any): Observable<any>  {
     return this.http.delete(`${this.appSettings.endPointTitan}General_Usuarios/${datos.id}`);
  }

}
