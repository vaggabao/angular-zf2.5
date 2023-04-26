import { Injectable } from "@angular/core";

@Injectable({
    providedIn: "root"
})
export class CartModel {
    public cart_id: number = 0;
    public customer_id: number = 0;
    public order_datetime: string = "";
    public sub_total: number = 0;
    public taxable_amount: number = 0;
    public discount: number = 0;
    public tax: number = 0;
    public shipping_total: number = 0;
    public total_amount: number = 0;
    public total_weight: number = 0;
    public company_name: string = "";
    public email: string = "";
    public first_name: string = "";
    public last_name: string = "";
    public phone: string = "";
    public shipping_mehod: string = "";
    public shipping_name: string = "";
    public shipping_address1: string = "";
    public shipping_address2: string = "";
    public shipping_address3: string = "";
    public shipping_city: string = "";
    public shipping_state: string = "";
    public shipping_country: string = "";
    public items: object[] = [];

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
