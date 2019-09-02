import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BaseformFields } from './baseform-fields';

describe('BaseformFields', () => {
  let component: BaseformFields;
  let fixture: ComponentFixture<BaseformFields>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BaseformFields ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BaseformFields);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
