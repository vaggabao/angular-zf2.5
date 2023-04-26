import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';
import { LoginService } from './service/login.service';
import { LocalStorageService } from './service/local-storage.service';
import { AppHeaderComponent } from "./components/app-header.component";
import { CartItemComponent } from './components/cart-item.component';
import { InputErrorMessageComponent } from './components/input-error-message.component';

@NgModule({
    imports: [
        CommonModule,
        RouterModule,
        HttpClientModule,
    ],
    exports: [
        AppHeaderComponent,
        CartItemComponent,
        InputErrorMessageComponent,
    ],
    declarations: [
        AppHeaderComponent,
        CartItemComponent,
        InputErrorMessageComponent
    ],
    providers: [
        LoginService,
        LocalStorageService,
    ],
})
export class CoreModule {
}
