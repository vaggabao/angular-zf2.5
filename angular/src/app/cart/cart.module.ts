import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { HttpClientModule } from '@angular/common/http';
import { CartRoutes } from './config/cart.routes';
import { CartComponent } from './components/cart.component';
import { CartService } from '../core/service/cart.service';
import { LocalStorageService } from '../core/service/local-storage.service';
import { CoreModule } from '../core/core.module';

@NgModule({
    declarations: [
        CartComponent,
    ],
    imports: [
        CommonModule,
        HttpClientModule,
        CoreModule,
        CartRoutes,
    ],
    exports: [
    ],
    providers: [
        CartService,
        LocalStorageService,
    ],
})
export class CartModule {
}
