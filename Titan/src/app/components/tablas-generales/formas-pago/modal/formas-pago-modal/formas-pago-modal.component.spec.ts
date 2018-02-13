import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FormasPagoModalComponent } from './formas-pago-modal.component';

describe('FormasPagoModalComponent', () => {
  let component: FormasPagoModalComponent;
  let fixture: ComponentFixture<FormasPagoModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FormasPagoModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FormasPagoModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
