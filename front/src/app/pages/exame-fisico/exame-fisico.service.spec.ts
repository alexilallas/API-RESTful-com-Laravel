import { TestBed } from '@angular/core/testing';

import { ExameFisicoService } from './exame-fisico.service';

describe('ExameFisicoService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ExameFisicoService = TestBed.get(ExameFisicoService);
    expect(service).toBeTruthy();
  });
});
