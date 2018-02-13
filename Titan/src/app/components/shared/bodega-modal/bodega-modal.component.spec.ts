import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BodegaModalComponent } from './bodega-modal.component';

describe('BodegaModalComponent', () => {
  let component: BodegaModalComponent;
  let fixture: ComponentFixture<BodegaModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BodegaModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BodegaModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
