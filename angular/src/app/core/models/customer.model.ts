import { Injectable } from "@angular/core";

@Injectable({
    providedIn: "root"
})
export class CustomerModel {
    public customer_id: number = 0;
    public email: string = "";
    public company_name: string = "";
    public first_name: string = "";
    public last_name: string = "";
    public phone: string = "";

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
