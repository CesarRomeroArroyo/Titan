import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListasPreciosModalComponent } from './listas-precios-modal.component';

describe('ListasPreciosModalComponent', () => {
  let component: ListasPreciosModalComponent;
  let fixture: ComponentFixture<ListasPreciosModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListasPreciosModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListasPreciosModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
