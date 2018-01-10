import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';


@Component({
  selector: 'app-data-table',
  templateUrl: './data-table.component.html',
  styleUrls: ['./data-table.component.css']
})
export class DataTableComponent implements OnInit, OnChanges {

  @Input() columns: any[];
  @Input() data: any[];
  @Input() options: boolean;
  @Output() editEvent = new EventEmitter<any>();
  @Output() deleteEvent = new EventEmitter<any>();
  private pageRegister: number;
  private pagesNumber: number;
  private registerNumber: number;
  private actualPage: number;
  constructor() {
    this.actualPage = 1;
  }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges): void {
    console.log(changes);
    if (changes.data.firstChange === false) {
      this.pageRegister = 10;
      this.registerNumber = this.data.length;
      this.pagesNumber = Math.ceil((this.registerNumber / 10));
      console.log(this.pageRegister, ' ', this.registerNumber, ' ', this.pagesNumber);
    }
  }

  onEditData(data: any) {
    this.editEvent.emit(data);
  }

  onDeleteData(data: any) {
    this.deleteEvent.emit(data);
  }

}
