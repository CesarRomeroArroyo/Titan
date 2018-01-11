import { TestBed, inject } from '@angular/core/testing';

import { BancosService } from './bancos.service';

describe('BancosService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [BancosService]
    });
  });

  it('should be created', inject([BancosService], (service: BancosService) => {
    expect(service).toBeTruthy();
  }));
});
