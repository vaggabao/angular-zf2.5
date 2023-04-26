import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { LoginRoutes } from './config/login.routes';
import { LoginComponent } from './components/login.component';
import { LoginFormComponent } from './components/login-form.component';
import { RegisterFormComponent } from './components/register-form.component';
import { LoginService } from '../core/service/login.service';
import { LocalStorageService } from '../core/service/local-storage.service';
import { CoreModule } from '../core/core.module';

@NgModule({
    declarations: [
        LoginComponent,
        LoginFormComponent,
        RegisterFormComponent,
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,
        CoreModule,
        LoginRoutes,
    ],
    exports: [
    ],
    providers: [
        LoginService,
        LocalStorageService,
    ],
})
export class LoginModule {
}
