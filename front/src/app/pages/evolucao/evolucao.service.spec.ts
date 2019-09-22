import { TestBed } from '@angular/core/testing';

import { EvolucaoService } from './evolucao.service';

describe('EvolucaoService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: EvolucaoService = TestBed.get(EvolucaoService);
    expect(service).toBeTruthy();
  });
});
