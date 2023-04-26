import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { HttpClientModule } from '@angular/common/http';
import { OrderRoutes } from './config/order.routes';
import { OrderComponent } from './components/order.component';
import { OrderService } from './service/order.service';
import { CoreModule } from '../core/core.module';

@NgModule({
    imports: [
        CommonModule,
        HttpClientModule,
        CoreModule,
        OrderRoutes,
    ],
    exports: [
    ],
    declarations: [
        OrderComponent,
    ],
    providers: [
        OrderService,
    ],
})
export class OrderModule {
}
