import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { CoreModule } from '../core/core.module';
import { ShippingRoutes } from './config/shipping.routes';
import { ShippingComponent } from './components/shipping.component';
import { InputErrorMessageComponent } from '../core/components/input-error-message.component';
import { CartService } from '../core/service/cart.service';
import { LocalStorageService } from '../core/service/local-storage.service';

@NgModule({
    declarations: [
        ShippingComponent,
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,
        CoreModule,
        ShippingRoutes,
    ],
    exports: [
    ],
    providers: [
        CartService,
        LocalStorageService,
    ],
})
export class ShippingModule {
}
