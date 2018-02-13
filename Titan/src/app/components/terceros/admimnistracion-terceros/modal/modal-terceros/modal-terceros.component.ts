import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal-terceros',
  templateUrl: './modal-terceros.component.html',
  styleUrls: ['./modal-terceros.component.css']
})
export class ModalTercerosComponent implements OnInit {
  @Input() data;
  @Input() numReg;
  @Output() savedEvent = new EventEmitter<void>();
  private dataForm;
  constructor() { }

  ngOnInit() {
  }

}
