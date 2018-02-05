import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { LoginService } from './../../services/shared/login.service';
import { AppSettings } from '../../app.settings';
import { SessionStorageService } from '../../services/shared/session-storage.service';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  @Output() logIn= new EventEmitter<void>();
  appUser = {usuario: '', pass: ''};
  constructor(private _loginService: LoginService, private _storage: SessionStorageService) { }

  ngOnInit() {
  }

  iniciarSesion() {
    this._loginService.login(this.appUser.usuario, this.appUser.pass).subscribe(
      result => {
        this._storage.agregar('TITAN-USERDATA', JSON.stringify(result));
        this.logIn.emit();
        console.log(result);

      },
      error => {
          console.log(<any>error);
      }
    );
  }

}
