import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { constants } from './constants.component';

describe('constants', () => {
  let component: constants;
  let fixture: ComponentFixture<constants>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ constants ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(constants);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
