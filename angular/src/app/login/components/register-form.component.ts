import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, ValidationErrors, ValidatorFn, AbstractControl } from '@angular/forms';
import { LoginService } from 'src/app/core/service/login.service';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';
import { Subscription } from 'rxjs';

@Component({
    selector: 'register-form',
    templateUrl: 'register-form.component.html'
})
export class RegisterFormComponent implements OnInit, OnDestroy {
    @Input() public redirect: string = "/";
    public validationMessages = {
        email: {
            required: "Email is required"
        },
        password: {
            required: "Password is required"
        },
        confirm_password: {
            required: "Confirm Password is required",
            passwordsNotMatch: "Confirm Password does not match with Password"
        },
        company_name: {
            required: "Company Name is required",
            maxlength: "Company Name is too long",
        },
        first_name: {
            required: "First Name is required",
            maxlength: "First Name is too long",
        },
        last_name: {
            required: "Last Name is required",
            maxlength: "Last Name is too long",
        },
    };
    public registerForm!: FormGroup;
    public valueChanges: Subscription;
    public errors = [];
    public submitErrors: { [key: string]: string } = {};
    public enableSubmitBtn = false;
    private checkPasswords: ValidatorFn;

    constructor(
        private route: ActivatedRoute,
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
        this.valueChanges = this.registerForm.valueChanges.subscribe(data => {
            this.errors = this.getFormValidationErrors();
            if (this.errors.length === 0) {
                this.enableSubmitBtn = true;
            }
        });
    }

    private buildForm() {
        this.checkPasswords = (group: AbstractControl): ValidationErrors | null => {
            let pass = group.get('password').value;
            let confirmPass = group.get('confirm_password').value
            group.get('confirm_password').setErrors({ passwordsNotMatch: true });
            return pass === confirmPass ? null : { passwordsNotMatch: true }
        }
        this.registerForm = this.formBuilder.group({
            email: ["", [Validators.required]],
            password: ["", [Validators.required]],
            confirm_password: ["", [Validators.required]],
            company_name: ["", Validators.maxLength(35)],
            first_name: ["", [Validators.required, Validators.maxLength(35)]],
            last_name: ["", [Validators.required, Validators.maxLength(35)]],
        });
        // this.registerForm.setValidators(this.checkPasswords);
    }

    private getFormValidationErrors() {
        let errors: any = [];
        Object.keys(this.registerForm.controls).forEach(key => {
            const controlErrors: ValidationErrors = this.registerForm.get(key).errors;
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
        if (this.registerForm.valid) {
            let registerData = this.registerForm.value;
            this.LoginService.register(registerData).subscribe(
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