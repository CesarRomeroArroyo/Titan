import { TestBed, inject } from '@angular/core/testing';

import { BodegasService } from './bodegas.service';

describe('BodegasService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [BodegasService]
    });
  });

  it('should be created', inject([BodegasService], (service: BodegasService) => {
    expect(service).toBeTruthy();
  }));
});
