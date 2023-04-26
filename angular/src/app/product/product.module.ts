import { NgModule } from '@angular/core';
import { CommonModule, CurrencyPipe } from "@angular/common";
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { ProductRoutes } from './config/product.routes';
import { ProductComponent } from './components/product.component';
import { ProductService } from '../core/service/product.service';
import { CartService } from '../core/service/cart.service';
import { LocalStorageService } from '../core/service/local-storage.service';

@NgModule({
    declarations: [
        ProductComponent,
    ],
    imports: [
        CommonModule,
        CurrencyPipe,
        FormsModule,
        HttpClientModule,
        ProductRoutes,
    ],
    exports: [
    ],
    providers: [
        ProductService,
        CartService,
        LocalStorageService,
    ],
})
export class ProductModule {
}
