import { TestBed } from '@angular/core/testing';

import { FichaAnamneseService } from './ficha-anamnese.service';

describe('FichaAnamineseService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: FichaAnamneseService = TestBed.get(FichaAnamneseService);
    expect(service).toBeTruthy();
  });
});
