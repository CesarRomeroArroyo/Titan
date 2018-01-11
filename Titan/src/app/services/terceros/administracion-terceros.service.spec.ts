import { TestBed, inject } from '@angular/core/testing';

import { AdministracionTercerosService } from './administracion-terceros.service';

describe('AdministracionTercerosService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [AdministracionTercerosService]
    });
  });

  it('should be created', inject([AdministracionTercerosService], (service: AdministracionTercerosService) => {
    expect(service).toBeTruthy();
  }));
});
