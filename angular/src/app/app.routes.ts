import { RouterModule } from "@angular/router";

export const AppRoutes = RouterModule.forRoot([
    {
        path: '',
        children: [
            {
                path: '',
                loadChildren: () => import('./home/home.module').then(m => m.HomeModule),
            },
            {
                path: 'product',
                loadChildren: () => import('./product/product.module').then(m => m.ProductModule),
            },
            {
                path: 'cart',
                loadChildren: () => import('./cart/cart.module').then(m => m.CartModule),
            },
            {
                path: 'shipping',
                loadChildren: () => import('./shipping/shipping.module').then(m => m.ShippingModule),
            },
            {
                path: 'payment',
                loadChildren: () => import('./payment/payment.module').then(m => m.PaymentModule),
            },
            {
                path: 'order',
                loadChildren: () => import('./order/order.module').then(m => m.OrderModule),
            },
            {
                path: 'login',
                loadChildren: () => import('./login/login.module').then(m => m.LoginModule),
            },
        ]
    },
], { scrollPositionRestoration: 'top' });