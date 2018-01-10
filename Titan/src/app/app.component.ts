import { Component } from '@angular/core';
import { AppSettings } from './app.settings';
import { SessionStorageService } from './services/shared/session-storage.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  isLogged: boolean;
  constructor(private _storage: SessionStorageService) {
  }

  onLogIn ($event) {
    this.isLogged = true;
  }

  onLogOut ($event) {
    this._storage.eliminar('TITAN-USERDATA');
    this.isLogged = false;
  }
}
