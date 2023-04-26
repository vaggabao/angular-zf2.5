import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { environment } from 'src/environments/environment';

interface OrderResponse {
    order: {
        [key: string]: any
    },
    success: number | undefined,
    errors: { [key: string]: any }
}

@Injectable()
export class OrderService {
    private apiUrl: string;

    constructor(private Http: HttpClient) {
        this.apiUrl = environment.api_url + '/order';
    }

    public getOrder(orderId: number) {
        return this.Http.get<OrderResponse>(this.apiUrl + '/' + orderId);
    }
}
