import { RouterModule } from "@angular/router";
import { ProductComponent } from "../components/product.component";

export const ProductRoutes = RouterModule.forChild([
    {
        path: ':id',
        component: ProductComponent,
    },
]);