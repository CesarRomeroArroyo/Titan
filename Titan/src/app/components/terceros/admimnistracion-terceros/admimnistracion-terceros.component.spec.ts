import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdmimnistracionTercerosComponent } from './admimnistracion-terceros.component';

describe('AdmimnistracionTercerosComponent', () => {
  let component: AdmimnistracionTercerosComponent;
  let fixture: ComponentFixture<AdmimnistracionTercerosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdmimnistracionTercerosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdmimnistracionTercerosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
