import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalMenusComponent } from './modal-menus.component';

describe('ModalMenusComponent', () => {
  let component: ModalMenusComponent;
  let fixture: ComponentFixture<ModalMenusComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalMenusComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalMenusComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
