import { TestBed } from '@angular/core/testing';

import { FichaAnamineseService } from './ficha-anaminese.service';

describe('FichaAnamineseService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: FichaAnamineseService = TestBed.get(FichaAnamineseService);
    expect(service).toBeTruthy();
  });
});
