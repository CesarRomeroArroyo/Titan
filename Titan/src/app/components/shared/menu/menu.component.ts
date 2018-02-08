import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { MenuService } from '../../../services/shared/menu.service';
import { PermisosService } from '../../../services/shared/permisos.service';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.css']
})
export class MenuComponent implements OnInit {
  @Output() selectOption = new EventEmitter<any>();
  menuOptions: any;
  optionSelected = {text: '', component: ''};
  constructor(private _menuService: MenuService, private _permisosService: PermisosService) { }

  ngOnInit() {
    this._permisosService.buscarPerfilUsuario().subscribe(
      result => {
        this._menuService.buscarMenus(result.perfil).subscribe(
          menu => {
            this.menuOptions = menu;
          },
          error => {
              console.log(<any>error);
          }
        );
      },
      error => {
          console.log(<any>error);
      }
    );
  }

  seleccionarOpcion(menuTexto: string, componente: string) {
    this.optionSelected.text = menuTexto;
    this.optionSelected.component = componente;
    this.selectOption.emit(this.optionSelected);
  }

}
