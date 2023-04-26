import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';

@Component({
    selector: 'app-login',
    templateUrl: 'login.component.html'
})
export class LoginComponent {
    protected redirect: string;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private LocalStorageService: LocalStorageService
    ) {
        this.redirect = this.route.snapshot.queryParamMap.get('redir') || "/";

        if (this.LocalStorageService.getData('customer')) {
            this.router.navigate(['/']);
        }
    }
}