import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CartService } from 'src/app/core/service/cart.service';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';

@Component({
    selector: 'app-payment',
    templateUrl: 'payment.component.html'
})
export class PaymentComponent implements OnInit {
    protected cartId: number = 0;
    protected cart: { [key: string]: any };

    constructor(
        private router: Router,
        private CartService: CartService,
        private LocalStorageService: LocalStorageService
    ) {
        if (!this.LocalStorageService.getData('customer')) {
            this.router.navigate(['/login'], {
                queryParams: {
                    redir: '/payment'
                }
            });
        }
        let cartId = this.LocalStorageService.getData('cart_id');
        this.cartId = cartId ? parseInt(cartId) : 0;
    }

    public ngOnInit() {
        this.getCart();
    }

    public getCart() {
        this.CartService.getCart(this.cartId).subscribe(
            (data) => {
                this.cart = data.cart;
            },
            error => {
                // alert();
            }
        )
    }

    public payCart() {
        this.CartService.payCart(this.cartId).subscribe(
            data => {
                if (data.success === 1) {
                    let orderRoute = '/order/' + data['order_id'];
                    this.router.navigate([orderRoute]);
                }
            }
        )
    }
}