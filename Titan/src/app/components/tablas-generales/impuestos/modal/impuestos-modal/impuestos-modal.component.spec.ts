import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImpuestosModalComponent } from './impuestos-modal.component';

describe('ImpuestosModalComponent', () => {
  let component: ImpuestosModalComponent;
  let fixture: ComponentFixture<ImpuestosModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImpuestosModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImpuestosModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
