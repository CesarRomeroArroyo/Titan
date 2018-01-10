import { Component, OnInit, Output, EventEmitter, ViewChild } from '@angular/core';
@Component({
  selector: 'app-titan',
  templateUrl: './titan.component.html',
  styleUrls: ['./titan.component.css']
})
export class TitanComponent implements OnInit {
  @Output() logOut= new EventEmitter<any>();

  selectedRow: string;
  tabsOptions: any[]= [{text: 'Inicio', component: 'inicio'}];
  constructor() {}

  ngOnInit() {
  }

  onLogOut() {
    this.logOut.emit();
  }

  createTab($event) {
    this.tabsOptions.push({text: $event.text, component: $event.component});
  }

  setClickedRow (index) {
    this.selectedRow = index;
  }

  closeTab (idx) {
    this.tabsOptions.splice(idx, 1);
  }
}
