import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { ToastrModule } from "ngx-toastr";

import { SidebarModule } from './sidebar/sidebar.module';
import { FooterModule } from './shared/footer/footer.module';
import { NavbarModule } from './shared/navbar/navbar.module';
import { FixedPluginModule } from './shared/fixedplugin/fixedplugin.module';

import { DataTablesModule } from 'angular-datatables';
import { ReactiveFormsModule } from '@angular/forms';
import { FormsModule } from '@angular/forms';
import { NgSelectModule } from '@ng-select/ng-select';

import { AppComponent } from './app.component';
import { AppRoutes } from './app.routing';

import { AdminLayoutComponent } from './layouts/admin-layout/admin-layout.component';
import { LoginComponent } from './auth/login/login.component';
import { DatatablesComponent } from './shared/datatables/datatables.component';

import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { NgxViacepModule } from '@brunoc/ngx-viacep';
import { NgxSmartModalModule } from 'ngx-smart-modal';
import { NgxMaskModule } from 'ngx-mask';

import { MessageService } from './services/messages/message.service';
import { LoginService } from './auth/login/login.service';

import { JwtInterceptor } from './services/interceptors/jwt.interceptor';
import { ErrorInterceptor } from './services/interceptors/error.interceptor';

@NgModule({
  declarations: [
    AppComponent,
    AdminLayoutComponent,
    DatatablesComponent,
    LoginComponent,
  ],
  imports: [
    BrowserAnimationsModule,
    RouterModule.forRoot(AppRoutes, {
      useHash: true
    }),
    SidebarModule,
    NavbarModule,
    ToastrModule.forRoot(),
    FooterModule,
    FixedPluginModule,
    HttpClientModule,
    DataTablesModule,
    FormsModule,
    ReactiveFormsModule,
    NgSelectModule,
    NgxViacepModule,
    NgxSmartModalModule.forRoot(),
    NgxMaskModule.forRoot()
  ],
  providers: [MessageService, LoginService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
