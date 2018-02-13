import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalTercerosComponent } from './modal-terceros.component';

describe('ModalTercerosComponent', () => {
  let component: ModalTercerosComponent;
  let fixture: ComponentFixture<ModalTercerosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalTercerosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalTercerosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
