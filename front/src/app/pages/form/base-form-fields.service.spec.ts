import { TestBed } from '@angular/core/testing';

import { BaseFormFieldsService } from './base-form-fields.service';

describe('BaseFormFieldsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: BaseFormFieldsService = TestBed.get(BaseFormFieldsService);
    expect(service).toBeTruthy();
  });
});
