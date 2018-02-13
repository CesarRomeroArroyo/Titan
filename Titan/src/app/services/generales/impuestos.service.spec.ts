import { TestBed, inject } from '@angular/core/testing';

import { ImpuestosService } from './impuestos.service';

describe('ImpuestosService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ImpuestosService]
    });
  });

  it('should be created', inject([ImpuestosService], (service: ImpuestosService) => {
    expect(service).toBeTruthy();
  }));
});
