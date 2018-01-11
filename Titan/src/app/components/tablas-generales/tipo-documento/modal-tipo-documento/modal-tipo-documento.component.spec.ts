import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalTipoDocumentoComponent } from './modal-tipo-documento.component';

describe('ModalTipoDocumentoComponent', () => {
  let component: ModalTipoDocumentoComponent;
  let fixture: ComponentFixture<ModalTipoDocumentoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalTipoDocumentoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalTipoDocumentoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
