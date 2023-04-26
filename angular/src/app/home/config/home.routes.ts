import { RouterModule } from "@angular/router";
import { HomeComponent } from "../components/home.component";

export const HomeRoutes = RouterModule.forChild([
    {
        path: '',
        component: HomeComponent,
    },
]);