import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { OrderService } from '../service/order.service';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';

@Component({
    selector: 'app-order',
    templateUrl: 'order.component.html'
})
export class OrderComponent implements OnInit {
    protected orderId: number = 0;
    protected order: { [key: string]: any };
    public addressLine1: string = "";
    public addressLine2: string = "";

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private OrderService: OrderService,
        private LocalStorageService: LocalStorageService,
    ) {
        let idParam = this.route.snapshot.paramMap.get('id');
        this.orderId = idParam ? parseInt(idParam) : 0;
        if (!this.LocalStorageService.getData('customer')) {
            this.router.navigate(['/login'], {
                queryParams: {
                    redir: '/order/' + this.orderId
                }
            });
        }
    }

    ngOnInit(): void {
        if (this.orderId > 0) {
            this.getOrder();
        } else {
            this.router.navigate(['/']);
        }
    }

    public getOrder() {
        this.OrderService.getOrder(this.orderId).subscribe(
            (data) => {
                if (data.order) {
                    this.order = data.order;
                    this.addressLine1 = data.order['shipping_address1'];
                    if (data.order['shipping_address2']) {
                        this.addressLine1 += ' ' + data.order['shipping_address2']
                    }
                    if (data.order['shipping_address3']) {
                        this.addressLine1 += ' ' + data.order['shipping_address3']
                    }
                    this.addressLine2 = data.order['shipping_city'] + ', ';
                    this.addressLine2 += data.order['shipping_state'] + ' ';
                    this.addressLine2 += data.order['shipping_country'];
                } else {
                    this.router.navigate(['/']);
                }
            },
            error => {
                this.router.navigate(['/']);
            }
        )
    }
}