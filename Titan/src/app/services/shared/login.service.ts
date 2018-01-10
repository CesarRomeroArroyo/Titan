import { Injectable } from '@angular/core';
import { AppSettings } from '../../app.settings';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { SessionStorageService } from './session-storage.service';
@Injectable()
export class LoginService {

  constructor(private appSettings: AppSettings, private http: HttpClient, private _storage: SessionStorageService) {

   }

   login(usuario: string, pass: string): Observable<any> {
    return this.http.get(`${this.appSettings.endPointCore}entry/?usuario=${usuario}&pass=${pass}`);
   }

   getUserLogged() {
    return JSON.parse(this._storage.obtener('TITAN-USERDATA'));
   }
}
