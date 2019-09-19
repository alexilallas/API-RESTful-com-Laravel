import { TestBed } from '@angular/core/testing';

import { HistoricoMedicoService } from './historico-medico.service';

describe('HistoricoMedicoService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: HistoricoMedicoService = TestBed.get(HistoricoMedicoService);
    expect(service).toBeTruthy();
  });
});
