import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { HttpClientModule } from '@angular/common/http';
import { PaymentRoutes } from './config/payment.routes';
import { PaymentComponent } from './components/payment.component';
import { CartService } from '../core/service/cart.service';
import { LocalStorageService } from '../core/service/local-storage.service';
import { CoreModule } from '../core/core.module';

@NgModule({
    imports: [
        CommonModule,
        HttpClientModule,
        CoreModule,
        PaymentRoutes,
    ],
    exports: [
    ],
    declarations: [
        PaymentComponent,
    ],
    providers: [
        CartService,
        LocalStorageService,
    ],
})
export class PaymentModule {
}
