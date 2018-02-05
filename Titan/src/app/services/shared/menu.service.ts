import { Injectable } from '@angular/core';
import { LoginService } from './login.service';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { AppSettings } from '../../app.settings';


@Injectable()
export class MenuService {
  constructor(private _loginSerice: LoginService, private http: HttpClient, private appSettings: AppSettings) { }

  buscarMenus(id): Observable<any> {
    return this.http.get(`${this.appSettings.endPointCore}General_Permisos/?id=${id}`);
  }


}
