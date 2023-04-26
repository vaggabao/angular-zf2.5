import { RouterModule } from "@angular/router";
import { LoginComponent } from "../components/login.component";

export const LoginRoutes = RouterModule.forChild([
    {
        path: '',
        component: LoginComponent,
    },
]);