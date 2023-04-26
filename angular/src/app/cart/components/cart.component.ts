import { Component, OnInit } from '@angular/core';
import { CartService } from 'src/app/core/service/cart.service';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';

@Component({
    selector: 'app-cart',
    templateUrl: 'cart.component.html'
})
export class CartComponent implements OnInit {
    protected cartId: number = 0;
    protected cart: { [key: string]: any };

    constructor(
        private CartService: CartService,
        private LocalStorageService: LocalStorageService
    ) {
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
                this.cartId = data.cart['cart_id'];
                this.LocalStorageService.saveData('cart_id', this.cartId.toString());
            },
            error => {
                // alert();
            }
        )
    }
}