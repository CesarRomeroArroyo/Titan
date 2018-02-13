import { TestBed, inject } from '@angular/core/testing';

import { ListasPreciosService } from './listas-precios.service';

describe('ListasPreciosService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ListasPreciosService]
    });
  });

  it('should be created', inject([ListasPreciosService], (service: ListasPreciosService) => {
    expect(service).toBeTruthy();
  }));
});
