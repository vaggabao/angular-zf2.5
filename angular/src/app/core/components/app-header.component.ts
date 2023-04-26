import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { LoginService } from '../service/login.service';
import { LocalStorageService } from '../service/local-storage.service';
import { CustomerModel } from '../models/customer.model';
import { Subscription } from 'rxjs';

@Component({
    selector: 'app-header',
    templateUrl: 'app-header.component.html'
})
export class AppHeaderComponent implements OnInit {
    public authToken: string = "";
    public customer: CustomerModel | null = null;
    public firstName: string = "";
    public loginSubscription!: Subscription;

    constructor(
        private router: Router,
        private LoginService: LoginService,
        private LocalStorageService: LocalStorageService
    ) {
    }

    ngOnInit() {
        let customer = this.LocalStorageService.getData('customer') || "";
        if (customer) {
            let parsedCustomer = JSON.parse(customer);
            this.authToken = this.LocalStorageService.getData('auth_token') || "";
            this.customer = new CustomerModel();
            this.customer.setData(parsedCustomer);
            this.firstName = parsedCustomer.first_name;
        }
        // this.loginSubscription = this.LoginService.loginData.subscribe(
        //     data => {
        //         console.log(data);
        //         if (data.auth_token != "") {
        //             this.authToken = data.auth_token;
        //             this.customer = new CustomerModel();
        //             this.customer.setData(data.customer);
        //         }
        //     }
        // )
    }

    onLogout() {
        this.LoginService.logout(this.authToken).subscribe(
            data => {
                console.log(data);
                this.customer = null;
                this.authToken = "";
                this.firstName = "";
                this.LocalStorageService.clearData();
                this.router.navigate(['/']);
            }
        )
    }
}
