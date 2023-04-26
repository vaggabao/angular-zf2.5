import { RouterModule } from "@angular/router";
import { CartComponent } from "../components/cart.component";

export const CartRoutes = RouterModule.forChild([
    {
        path: '',
        component: CartComponent,
    },
]);