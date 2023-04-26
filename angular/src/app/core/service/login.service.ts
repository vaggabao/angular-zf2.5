import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { environment } from 'src/environments/environment';
import { BehaviorSubject } from 'rxjs';

interface LoginResponse {
    auth_token: string,
    customer: {
        [key: string]: any
    },
    success: number | undefined,
    errors: {
        [key: string]: any
    }
}

@Injectable()
export class LoginService {
    private loginEndPoint: string;
    private registerEndPoint: string;
    private loginDataSubject = new BehaviorSubject<any>({});
    public loginData = this.loginDataSubject.asObservable();

    constructor(private Http: HttpClient) {
        this.loginEndPoint = environment.api_url + '/authentication';
        this.registerEndPoint = environment.api_url + '/registration';
        this.loginDataSubject.next({
            auth_token: "",
            customer: null
        });
    }

    public setLoginData(loginData: object) {
        this.loginDataSubject.next(loginData);
    }

    public register(data: any) {
        let params = {
            email: data.email,
            password: data.password,
            confirm_password: data.confirm_password,
            company_name: data.company_name,
            first_name: data.first_name,
            last_name: data.last_name,
        };
        return this.Http.post<LoginResponse>(this.registerEndPoint, params);
    }

    public login(email: string, password: string) {
        let params = {
            email: email,
            password: password
        };
        return this.Http.post<LoginResponse>(this.loginEndPoint, params);
    }

    public logout(authToken: string) {
        let endpoint = this.loginEndPoint + '/' + authToken;
        return this.Http.delete<LoginResponse>(endpoint);
    }
}
