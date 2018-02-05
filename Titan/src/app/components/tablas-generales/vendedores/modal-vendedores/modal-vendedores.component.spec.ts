import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalVendedoresComponent } from './modal-vendedores.component';

describe('ModalVendedoresComponent', () => {
  let component: ModalVendedoresComponent;
  let fixture: ComponentFixture<ModalVendedoresComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalVendedoresComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalVendedoresComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
