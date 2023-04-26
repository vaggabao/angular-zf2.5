import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse } from "@angular/common/http";
import { environment } from 'src/environments/environment';

interface ProductListResponse {
    products: []
}

interface ProductResponse {
    product: {}
}

@Injectable()
export class ProductService {
    private apiUrl: string;

    constructor(private Http: HttpClient) {
        this.apiUrl = environment.api_url + '/products';
    }

    public getProducts() {
        return this.Http.get<ProductListResponse>(this.apiUrl);
    }

    public getProduct(productId: number) {
        return this.Http.get<ProductResponse>(this.apiUrl + '/' + productId);
    }
}
