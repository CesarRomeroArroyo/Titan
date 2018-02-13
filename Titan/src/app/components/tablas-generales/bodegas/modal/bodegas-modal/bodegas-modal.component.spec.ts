import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BodegasModalComponent } from './bodegas-modal.component';

describe('BodegasModalComponent', () => {
  let component: BodegasModalComponent;
  let fixture: ComponentFixture<BodegasModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BodegasModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BodegasModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
