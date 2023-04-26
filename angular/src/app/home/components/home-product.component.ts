import { Component, Input } from '@angular/core';
import { ProductModel } from 'src/app/core/models/product.model';
import { environment } from 'src/environments/environment';

@Component({
    selector: 'home-product',
    templateUrl: 'home-product.component.html'
})
export class HomeProductComponent {
    @Input() productModel!: ProductModel;
    protected imagePath: string;

    constructor() {
        this.imagePath = environment.img_upload_path;
    }
}