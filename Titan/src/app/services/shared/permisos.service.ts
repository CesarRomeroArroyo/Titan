import { Injectable } from '@angular/core';
import { LoginService } from './login.service';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { AppSettings } from '../../app.settings';


@Injectable()
export class PermisosService {
  userLogged: any;
  constructor(private http: HttpClient, private appSettings: AppSettings, private _loginSerice: LoginService) {
    this.userLogged = this._loginSerice.getUserLogged();
  }

  buscarPerfilUsuario(): Observable<any> {
    return this.http.get(`${this.appSettings.endPointCore}General_Perfil_Usuario/?id=${this.userLogged.id}`);
  }

}
