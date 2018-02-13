import { TestBed, inject } from '@angular/core/testing';

import { CondicionPagoService } from './condicion-pago.service';

describe('CondicionPagoService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CondicionPagoService]
    });
  });

  it('should be created', inject([CondicionPagoService], (service: CondicionPagoService) => {
    expect(service).toBeTruthy();
  }));
});
