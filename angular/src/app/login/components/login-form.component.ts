import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, ValidationErrors } from '@angular/forms';
import { LoginService } from 'src/app/core/service/login.service';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';
import { Subscription } from 'rxjs';

@Component({
    selector: 'login-form',
    templateUrl: 'login-form.component.html'
})
export class LoginFormComponent implements OnInit, OnDestroy {
    @Input() public redirect: string = "/";
    public validationMessages = {
        email: {
            required: "Email is required"
        },
        password: {
            required: "Password is required"
        },
    };
    public loginForm!: FormGroup;
    public valueChanges: Subscription;
    public errors = [];
    public submitErrors: { [key: string]: string } = {};
    public loginError: string = "";
    public enableSubmitBtn = false;

    constructor(
        private router: Router,
        private formBuilder: FormBuilder,
        private LoginService: LoginService,
        private LocalStorageService: LocalStorageService
    ) { }

    ngOnInit(): void {
        this.initializeForm();
    }

    ngOnDestroy(): void {
        this.valueChanges.unsubscribe();
    }

    private initializeForm() {
        this.buildForm();
        this.valueChanges = this.loginForm.valueChanges.subscribe(data => {
            this.errors = this.getFormValidationErrors();
            if (this.errors.length === 0) {
                this.enableSubmitBtn = true;
            }
        });
    }

    private buildForm() {
        this.loginForm = this.formBuilder.group({
            email: ['', [Validators.required]],
            password: ['', [Validators.required]],
        });
    }

    private getFormValidationErrors() {
        let errors: any = [];
        Object.keys(this.loginForm.controls).forEach(key => {
            const controlErrors: ValidationErrors = this.loginForm.get(key).errors;
            if (controlErrors != null) {
                Object.keys(controlErrors).forEach(keyError => {
                    if (typeof this.validationMessages[key][keyError] != 'undefined') {
                        errors.push(this.validationMessages[key][keyError]);
                    }
                });
            }
        });

        return errors;
    }

    public submit() {
        this.submitErrors = {};
        if (this.loginForm.valid) {
            let loginData = this.loginForm.value;
            this.LoginService.login(loginData.email, loginData.password).subscribe(
                data => {
                    if (data.success === 1) {
                        this.LoginService.setLoginData({
                            auth_token: data.auth_token,
                            customer: data.customer
                        });
                        this.LocalStorageService.saveData('auth_token', data.auth_token);
                        this.LocalStorageService.saveData('customer', JSON.stringify(data.customer));
                        this.router.navigate([this.redirect]);
                    } else {
                        let errors = data.errors;
                        for (let errorKey of Object.keys(errors)) {
                            for (let validatorKey of Object.keys(errors[errorKey])) {
                                this.submitErrors[errorKey] = errors[errorKey][validatorKey];
                            }
                        }
                    }
                }
            )
        }
    }
}