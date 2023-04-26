import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, ValidationErrors } from '@angular/forms';
import { CartService } from 'src/app/core/service/cart.service';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';
import { Subscription } from 'rxjs';

@Component({
    selector: 'app-shipping',
    templateUrl: 'shipping.component.html'
})
export class ShippingComponent implements OnInit, OnDestroy {
    protected cartId: number = 0;
    protected validationMessages = {
        name: {
            required: "Name is required",
            maxlength: "Maximum of 35 characters only"
        },
        address1: {
            required: "Address 1 is required",
            maxlength: "Maximum of 35 characters only"
        },
        address2: {
            maxlength: "Maximum of 35 characters only"
        },
        address3: {
            maxlength: "Maximum of 35 characters only"
        },
        city: {
            required: "City is required",
            maxlength: "Maximum of 35 characters only"
        },
        state: {
            required: "State is required",
            maxlength: "Maximum of 35 characters only"
        },
        country: {
            required: "Country is required",
            maxlength: "Maximum of 35 characters only"
        },
        shipping_method: {
            required: "Shipping Method is required"
        },
    };
    public shippingForm!: FormGroup;
    public valueChanges: Subscription;
    public shippingOptions = {
        ground: 0,
        expedited: 0
    };
    public errors = [];
    public submitErrors: { [key: string]: string } = {};
    public enableSubmitBtn = false;

    constructor(
        private router: Router,
        private formBuilder: FormBuilder,
        private CartService: CartService,
        private LocalStorageService: LocalStorageService
    ) {
        if (!this.LocalStorageService.getData('customer')) {
            this.router.navigate(['/login'], {
                queryParams: {
                    redir: '/shipping'
                }
            });
        }
        let cartId = this.LocalStorageService.getData('cart_id');
        this.cartId = cartId ? parseInt(cartId) : 0;
    }

    ngOnInit(): void {
        let cartId = this.LocalStorageService.getData('cart_id') || 0;
        this.valueChanges = this.CartService.getShippingMethods(Number(cartId)).subscribe(
            data => {
                this.shippingOptions.ground = data.ground;
                this.shippingOptions.expedited = data.expedited;
            }
        )
        this.initializeForm();
    }

    ngOnDestroy(): void {
        this.valueChanges.unsubscribe();
    }

    private initializeForm() {
        this.buildForm();
        this.shippingForm.valueChanges.subscribe(data => {
            this.errors = this.getFormValidationErrors();
            if (this.errors.length === 0) {
                this.enableSubmitBtn = true;
            }
        });
    }

    private buildForm() {
        this.shippingForm = this.formBuilder.group({
            name: ["", [Validators.required, Validators.maxLength(35)]],
            address1: ["", [Validators.required, Validators.maxLength(35)]],
            address2: ["", Validators.maxLength(35)],
            address3: ["", Validators.maxLength(35)],
            city: ["", [Validators.required, Validators.maxLength(35)]],
            state: ["", [Validators.required, Validators.maxLength(35)]],
            country: ["", [Validators.required, Validators.maxLength(35)]],
            shipping_method: ["Ground", [Validators.required, Validators.maxLength(35)]],
        });
    }

    private getFormValidationErrors() {
        let errors: any = [];
        Object.keys(this.shippingForm.controls).forEach(key => {
            const controlErrors: ValidationErrors = this.shippingForm.get(key).errors;
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
        if (this.shippingForm.valid) {
            let shippingData = this.shippingForm.value;
            this.CartService.saveShipping(this.cartId, shippingData).subscribe(
                data => {
                    if (data.success === 1) {
                        this.router.navigate(['/payment']);
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