import { Component, Input } from '@angular/core';
import { environment } from 'src/environments/environment';

type CartItem = { [key: string]: any };
@Component({
    selector: 'cart-item',
    templateUrl: 'cart-item.component.html',
})
export class CartItemComponent {
    @Input() item!: CartItem;
    protected imagePath: string;

    constructor() {
        this.imagePath = environment.img_upload_path;
    }
}