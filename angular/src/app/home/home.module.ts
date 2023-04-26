import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { HomeRoutes } from './config/home.routes';
import { HomeComponent } from './components/home.component';
import { HomeProductComponent } from './components/home-product.component';
import { ProductService } from '../core/service/product.service';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
    declarations: [
        HomeComponent,
        HomeProductComponent,
    ],
    imports: [
        CommonModule,
        HttpClientModule,
        HomeRoutes,
    ],
    exports: [
    ],
    providers: [
        ProductService,
    ],
})
export class HomeModule {
}
