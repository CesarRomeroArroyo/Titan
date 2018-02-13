import { Component, OnInit, ComponentFactoryResolver, ViewContainerRef, ViewChild, Input,
  OnDestroy, ComponentRef } from '@angular/core';
import { InicioComponent } from '../../inicio/inicio.component';
import { TipoDocumentoComponent } from './../../tablas-generales/tipo-documento/tipo-documento.component';
import { BancosComponent } from '../../tablas-generales/bancos/bancos.component';
import { AdmimnistracionTercerosComponent } from '../../terceros/admimnistracion-terceros/admimnistracion-terceros.component';
import { PerfilesComponent } from '../../aplicacion/perfiles/perfiles.component';
import { UsuariosComponent } from '../../aplicacion/usuarios/usuarios.component';
import { MenusComponent } from '../../aplicacion/menus/menus.component';
import { PermisosComponent } from '../../aplicacion/permisos/permisos.component';
import { AsignarPerfilComponent } from '../../aplicacion/asignar-perfil/asignar-perfil.component';
import { ListasPreciosComponent } from '../../tablas-generales/listas-precios/listas-precios.component';
import { ImpuestosComponent } from '../../tablas-generales/impuestos/impuestos.component';
import { BodegasComponent } from '../../tablas-generales/bodegas/bodegas.component';
import { FormasPagoComponent } from '../../tablas-generales/formas-pago/formas-pago.component';


@Component({
  selector: 'app-dynamic',
  templateUrl: './dynamic.component.html',
  styleUrls: ['./dynamic.component.css']
})
export class DynamicComponent implements OnInit, OnDestroy {

  @ViewChild('container', { read: ViewContainerRef })
  container: ViewContainerRef;

  @Input()
  type: string;

  @Input()
    context: any;

  private mappings = {
    'inicio': InicioComponent,
    'listTipoDocumento': TipoDocumentoComponent,
    'listBancos': BancosComponent,
    'listClientes': AdmimnistracionTercerosComponent,
    'lisUsuarios': UsuariosComponent,
    'listPrefil': PerfilesComponent,
    'listMenu': MenusComponent,
    'listPermisos': PermisosComponent,
    'listAsignarPerfil': AsignarPerfilComponent,
    'listListaPrecios': ListasPreciosComponent,
    'listImpuestos': ImpuestosComponent,
    'listBodegas': BodegasComponent,
    'listCondicionesPago': FormasPagoComponent,
    'listAdministracion': AdmimnistracionTercerosComponent
  };

  private componentRef: ComponentRef<{}>;

  constructor(
      private componentFactoryResolver: ComponentFactoryResolver) {
  }
  getComponentType(typeName: string) {
    const type = this.mappings[typeName];
    return type;
  }
  ngOnInit() {
    if (this.type) {
        const componentType = this.getComponentType(this.type);
        const factory = this.componentFactoryResolver.resolveComponentFactory(componentType);
        this.componentRef = this.container.createComponent(factory);

        const instance = <DynamicComponent> this.componentRef.instance;
        instance.context = this.context;

    }
  }

  ngOnDestroy() {
    if (this.componentRef) {
        this.componentRef.destroy();
        this.componentRef = null;
    }
  }

}
