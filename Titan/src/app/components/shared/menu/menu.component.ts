import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { MenuService } from '../../../services/shared/menu.service';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.css']
})
export class MenuComponent implements OnInit {
  @Output() selectOption = new EventEmitter<any>();
  menuOptions: any;
  optionSelected = {text: '', component: ''};
  constructor(private _menuService: MenuService) { }

  ngOnInit() {
    this._menuService.buscarMenus().subscribe(
      result => {
        this.menuOptions = result;
        console.log(result);

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
