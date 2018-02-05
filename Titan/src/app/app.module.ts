import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppSettings } from './app.settings';

import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { ModalModule } from 'ngx-bootstrap';
import { PaginationModule } from 'ngx-bootstrap/pagination';
import { BsModalService } from 'ngx-bootstrap/modal';

import { LoginService } from './services/shared/login.service';
import { CatchInterceptorService } from './services/shared/http-interceptor.service';
import { SessionStorageService } from './services/shared/session-storage.service';
import { MenuService } from './services/shared/menu.service';
import { TipoDocumentoService } from './services/generales/tipo-documento.service';
import { BancosService } from './services/generales/bancos.service';
import { AdministracionTercerosService } from './services/terceros/administracion-terceros.service';
import { PermisosService } from './services/shared/permisos.service';



import { AppComponent } from './app.component';
import { AlertsComponent } from './components/shared/alerts/alerts.component';
import { MenuComponent } from './components/shared/menu/menu.component';
import { ProfileTabComponent } from './components/shared/profile-tab/profile-tab.component';
import { LoginComponent } from './components/login/login.component';
import { TitanComponent } from './components/titan/titan.component';
import { TipoDocumentoComponent } from './components/tablas-generales/tipo-documento/tipo-documento.component';
import { DynamicComponent } from './components/shared/dynamic/dynamic.component';
import { InicioComponent } from './components/inicio/inicio.component';
import { DataTableComponent } from './components/shared/data-table/data-table.component';
import { ModalTipoDocumentoComponent } from './components/tablas-generales/tipo-documento/modal-tipo-documento/modal-tipo-documento.component';
import { BancosComponent } from './components/tablas-generales/bancos/bancos.component';
import { ModalBancosComponent } from './components/tablas-generales/bancos/modal-bancos/modal-bancos.component';
import { AdmimnistracionTercerosComponent } from './components/terceros/admimnistracion-terceros/admimnistracion-terceros.component';
import { ModalConfirmComponent } from './components/shared/modal-confirm/modal-confirm.component';
import { VendedoresComponent } from './components/tablas-generales/vendedores/vendedores.component';
import { ModalVendedoresComponent } from './components/tablas-generales/vendedores/modal-vendedores/modal-vendedores.component';





@NgModule({
  declarations: [
    AppComponent,
    AlertsComponent,
    MenuComponent,
    ProfileTabComponent,
    LoginComponent,
    TitanComponent,
    TipoDocumentoComponent,
    DynamicComponent,
    InicioComponent,
    DataTableComponent,
    ModalTipoDocumentoComponent,
    BancosComponent,
    ModalBancosComponent,
    AdmimnistracionTercerosComponent,
    ModalConfirmComponent,
    VendedoresComponent,
    ModalVendedoresComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    PaginationModule.forRoot(),
    ModalModule.forRoot()
  ],
  entryComponents: [
    InicioComponent,
    TipoDocumentoComponent,
    BancosComponent,
    AdmimnistracionTercerosComponent,
    ModalConfirmComponent,
    VendedoresComponent
  ],
  providers: [
    AppSettings,
    LoginService,
    SessionStorageService,
    MenuService,
    BsModalService,
    TipoDocumentoService,
    AdministracionTercerosService,
    PermisosService,
    BancosService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: CatchInterceptorService,
      multi: true
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
