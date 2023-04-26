import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { ProductModel } from 'src/app/core/models/product.model';
import { ProductService } from 'src/app/core/service/product.service';
import { CartService } from 'src/app/core/service/cart.service';
import { LocalStorageService } from 'src/app/core/service/local-storage.service';
import { environment } from 'src/environments/environment';

@Component({
    selector: 'app-product',
    templateUrl: 'product.component.html'
})
export class ProductComponent implements OnInit {
    private productId: number;
    private cartId: number;
    protected product: ProductModel;
    protected imagePath: string;
    protected qty: number;
    protected totalPrice: number;
    protected disableAddToCartBtn: boolean;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private ProductService: ProductService,
        private CartService: CartService,
        private LocalStorageService: LocalStorageService
    ) {
        this.productId = 0;
        this.product = new ProductModel();
        this.qty = 0;
        this.totalPrice = 0;
        this.disableAddToCartBtn = true;
        this.imagePath = environment.img_upload_path;

        let cartId = this.LocalStorageService.getData('cart_id');
        this.cartId = cartId ? parseInt(cartId) : 0;
    }

    ngOnInit() {
        let idParam = this.route.snapshot.paramMap.get('id');
        this.productId = idParam ? parseInt(idParam) : 0;
        if (this.productId > 0) {
            this.getProduct(this.productId);
        } else {
            this.router.navigate(['/']);
        }
    }

    public getProduct(productId: number) {
        this.ProductService.getProduct(productId).subscribe(
            data => {
                this.product.setData(data.product);
                let productData = this.product.getData();
                if (productData.stock_qty > 0) {
                    this.qty = 1;
                    this.totalPrice = productData.price;
                    this.disableAddToCartBtn = false;
                }
            }
        )
    }

    public addToCart() {
        this.CartService.addToCart(this.cartId, this.productId, this.qty).subscribe(
            data => {
                if (data.success) {
                    this.LocalStorageService.saveData('cart_id', data.cart['cart_id'])
                    this.router.navigate(['/cart']);
                }
            }
        )
    }

    public qtyOnChange() {
        let productData = this.product.getData();
        this.qty = this.qty <= productData.stock_qty ? this.qty : productData.stock_qty;
        this.totalPrice = this.qty * productData.price;
        this.disableAddToCartBtn = this.totalPrice > 0 ? false : true;
    }
}