import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutes } from './app.routes';
import { CoreModule } from './core/core.module';
import { AppComponent } from './app.component';

@NgModule({
    imports: [
        BrowserModule,
        AppRoutes,
        CoreModule,
    ],
    declarations: [
        AppComponent,
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule { }
