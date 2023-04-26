import { RouterModule } from "@angular/router";
import { OrderComponent } from "../components/order.component";

export const OrderRoutes = RouterModule.forChild([
    {
        path: ':id',
        component: OrderComponent,
    },
]);