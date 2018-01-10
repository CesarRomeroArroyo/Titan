import { Injectable } from '@angular/core';

@Injectable()
export class SessionStorageService {

  constructor() { }

  obtener (key: string) {
    return sessionStorage.getItem(key);
  }

  agregar ( key: string, data: any ) {
    return sessionStorage.setItem(key, data);
  }

  eliminar (key: string) {
    return sessionStorage.removeItem(key);
  }

}
