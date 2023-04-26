import { RouterModule } from "@angular/router";
import { PaymentComponent } from "../components/payment.component";

export const PaymentRoutes = RouterModule.forChild([
    {
        path: '',
        component: PaymentComponent,
    },
]);