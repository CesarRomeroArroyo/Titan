import { Component, OnInit, Output, EventEmitter, Input } from '@angular/core';

@Component({
  selector: 'app-alerts',
  templateUrl: './alerts.component.html',
  styleUrls: ['./alerts.component.css']
})
export class AlertsComponent implements OnInit {
  @Output() confirmEvent = new EventEmitter<void>();
  @Output() declineEvent = new EventEmitter<void>();
  @Input() textInput;
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
