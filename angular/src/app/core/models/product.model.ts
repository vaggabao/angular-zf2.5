import { Injectable } from "@angular/core";

@Injectable()
export class ProductModel {
    public product_id: number = 0;
    public product_name: string = "";
    public product_desc: string = "";
    public product_image: string = "";
    public product_thumbnail: string = "";
    public weight: number = 0;
    public price: number = 0;
    public stock_qty: number = 0;
    public taxable_flag: string = "";

    setData(data: object) {
        Object.keys(this).forEach((key) => {
            if (key in data) {
                this[key as keyof object] = data[key as keyof object];
            }
        });
        return this;
    }

    getData() {
        return JSON.parse(JSON.stringify(this));
    }
}
