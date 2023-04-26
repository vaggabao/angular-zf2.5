import { RouterModule } from "@angular/router";
import { ShippingComponent } from "../components/shipping.component";

export const ShippingRoutes = RouterModule.forChild([
    {
        path: '',
        component: ShippingComponent,
    },
]);