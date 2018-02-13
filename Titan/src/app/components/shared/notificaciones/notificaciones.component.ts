import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-notificaciones',
  templateUrl: './notificaciones.component.html',
  styleUrls: ['./notificaciones.component.css']
})
export class NotificacionesComponent implements OnInit {
  @Input() tipo: any;
  @Input() texto: string;
  constructor() { }

  ngOnInit() {
  }

}
