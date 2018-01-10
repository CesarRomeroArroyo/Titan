import { Injectable } from '@angular/core';
import { LoginService } from './login.service';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { AppSettings } from '../../app.settings';


@Injectable()
export class MenuService {
  userLogged: any;
  constructor(private _loginSerice: LoginService, private http: HttpClient, private appSettings: AppSettings) {
    this.userLogged = this._loginSerice.getUserLogged();
  }

  buscarMenus(): Observable<any> {
    return this.http.get(`${this.appSettings.endPointCore}buscarMenusPerfil/?iduser=${this.userLogged.iduser}`);
  }


}
