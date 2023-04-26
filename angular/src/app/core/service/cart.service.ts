import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { environment } from 'src/environments/environment';

interface CartResponseInterface {
    cart: { [key: string]: any },
    success: number | undefined,
    errors: { [key: string]: any },
    [key: string]: any
}

interface ShippingMethodResponse {
    ground: number,
    expedited: number
}

@Injectable()
export class CartService {
    private apiUrl: string;

    constructor(private Http: HttpClient) {
        this.apiUrl = environment.api_url + '/cart';
    }

    public getCart(cartId: number) {
        return this.Http.get<CartResponseInterface>(this.apiUrl + '/' + cartId);
    }

    public addToCart(cartId: number, productId: number, qty: number) {
        let endpoint = this.apiUrl + '/' + cartId + '/items';
        let params = {
            product_id: productId,
            qty: qty
        };
        return this.Http.post<CartResponseInterface>(endpoint, params);
    }

    public saveShipping(cartId: number, shippingData: { [key: string]: any }) {
        let endpoint = this.apiUrl + '/' + cartId + '/shipping';
        let params = {
            name: shippingData['name'],
            address1: shippingData['address1'],
            address2: shippingData['address2'],
            address3: shippingData['address3'],
            city: shippingData['city'],
            state: shippingData['state'],
            country: shippingData['country'],
            shipping_method: shippingData['shipping_method']
        };
        return this.Http.put<CartResponseInterface>(endpoint, params);
    }

    public getShippingMethods(cartId: number) {
        let endpoint = this.apiUrl + '/' + cartId + '/shipping-methods';
        return this.Http.get<ShippingMethodResponse>(endpoint);
    }

    public payCart(cartId: number) {
        let endpoint = this.apiUrl + '/' + cartId + '/payment';
        return this.Http.post<CartResponseInterface>(endpoint, {});
    }
}
