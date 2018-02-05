import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal-confirm',
  templateUrl: './modal-confirm.component.html',
  styleUrls: ['./modal-confirm.component.css']
})
export class ModalConfirmComponent implements OnInit {
  @Output() confirmEvent = new EventEmitter<void>();
  @Output() declineEvent = new EventEmitter<void>();
  constructor() { }

  ngOnInit() {
  }

  confirm() {
    this.confirmEvent.emit();
  }

  decline() {
    this.declineEvent.emit();
  }
}
