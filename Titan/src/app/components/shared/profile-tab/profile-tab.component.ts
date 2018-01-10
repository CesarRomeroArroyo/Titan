import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { LoginService } from '../../../services/shared/login.service';


@Component({
  selector: 'app-profile-tab',
  templateUrl: './profile-tab.component.html',
  styleUrls: ['./profile-tab.component.css']
})
export class ProfileTabComponent implements OnInit {
  @Output() logOut= new EventEmitter<any>();
  userLogged: any;
  constructor(private _loginSerice: LoginService) { }

  ngOnInit() {
    this.userLogged = this._loginSerice.getUserLogged();
    console.log(this.userLogged);
  }

  onLogout () {
    this.logOut.emit();
  }

}
