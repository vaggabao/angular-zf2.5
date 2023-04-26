import { Component, OnInit } from '@angular/core';
import { ProductService } from 'src/app/core/service/product.service';

@Component({
    selector: 'app-home',
    templateUrl: 'home.component.html'
})
export class HomeComponent implements OnInit {
    products = [];

    constructor(protected ProductService: ProductService) { }

    public ngOnInit() {
        this.getProducts();
    }

    public getProducts() {
        this.ProductService.getProducts().subscribe(
            data => {
                this.products = data.products;
            },
            error => {
                // alert();
            }
        )
    }
}