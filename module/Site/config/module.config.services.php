<?php

use Site\Controller\IndexController;
use Site\ServiceFactory\Controller\IndexControllerFactory;
use Site\Controller\ProductController;
use Site\ServiceFactory\Controller\ProductControllerFactory;
use Site\Controller\CartController;
use Site\ServiceFactory\Controller\CartControllerFactory;
use Site\Controller\ShippingController;
use Site\ServiceFactory\Controller\ShippingControllerFactory;
use Site\Controller\PaymentController;
use Site\ServiceFactory\Controller\PaymentControllerFactory;
use Site\Controller\OrderController;
use Site\ServiceFactory\Controller\OrderControllerFactory;
use Site\Controller\LoginController;
use Site\ServiceFactory\Controller\LoginControllerFactory;
use Site\ViewHelper\HeaderView;
use Site\ServiceFactory\ViewHelper\HeaderViewFactory;
use Site\Helper\CartHelper;
use Site\ServiceFactory\Helper\CartHelperFactory;
use Site\Helper\PaymentHelper;
use Site\ServiceFactory\Helper\PaymentHelperFactory;
use Site\Helper\RegisterHelper;
use Site\ServiceFactory\Helper\RegisterHelperFactory;
use Site\Service\ProductService;
use Site\ServiceFactory\Service\ProductServiceFactory;
use Site\Service\CartService;
use Site\ServiceFactory\Service\CartServiceFactory;
use Site\Service\ShippingService;
use Site\ServiceFactory\Service\ShippingServiceFactory;
use Site\Service\OrderService;
use Site\ServiceFactory\Service\OrderServiceFactory;
use Site\Service\LoginService;
use Site\ServiceFactory\Service\LoginServiceFactory;
use Site\Model\Product;
use Site\Model\ProductTable;
use Site\ServiceFactory\Model\ProductTableFactory;
use Site\Model\Cart;
use Site\Model\CartTable;
use Site\ServiceFactory\Model\CartTableFactory;
use Site\Model\CartItem;
use Site\Model\CartItemTable;
use Site\ServiceFactory\Model\CartItemTableFactory;
use Site\Model\Customer;
use Site\Model\CustomerTable;
use Site\ServiceFactory\Model\CustomerTableFactory;
use Site\Model\Shipping;
use Site\Model\ShippingTable;
use Site\ServiceFactory\Model\ShippingTableFactory;
use Site\Model\JobOrder;
use Site\Model\JobOrderTable;
use Site\ServiceFactory\Model\JobOrderTableFactory;
use Site\Model\JobItem;
use Site\Model\JobItemTable;
use Site\ServiceFactory\Model\JobItemTableFactory;
use Site\Filter\LoginFilter;
use Site\Filter\RegisterFilter;
use Site\Filter\AddToCartFilter;
use Site\Filter\ShippingFilter;

return array(
    'controllers' => array(
        'factories' => array(
            // Controllers
            IndexController::class => IndexControllerFactory::class,
            ProductController::class => ProductControllerFactory::class,
            CartController::class => CartControllerFactory::class,
            ShippingController::class => ShippingControllerFactory::class,
            PaymentController::class => PaymentControllerFactory::class,
            OrderController::class => OrderControllerFactory::class,
            LoginController::class => LoginControllerFactory::class,
        )
    ),
    'service_manager' => array(
        'factories' => array(
            // Helpers
            CartHelper::class => CartHelperFactory::class,
            PaymentHelper::class => PaymentHelperFactory::class,
            RegisterHelper::class => RegisterHelperFactory::class,

            // Services
            ProductService::class => ProductServiceFactory::class,
            CartService::class => CartServiceFactory::class,
            ShippingService::class => ShippingServiceFactory::class,
            OrderService::class => OrderServiceFactory::class,
            LoginService::class => LoginServiceFactory::class,

            // View Helpers
            HeaderView::class => HeaderViewFactory::class,

            // Tables
            ProductTable::class => ProductTableFactory::class,
            CartTable::class => CartTableFactory::class,
            CartItemTable::class => CartItemTableFactory::class,
            CustomerTable::class => CustomerTableFactory::class,
            ShippingTable::class => ShippingTableFactory::class,
            JobOrderTable::class => JobOrderTableFactory::class,
            JobItemTable::class => JobItemTableFactory::class,
        ),
        'invokables' => array(
            // Models
            Product::class => Product::class,
            Cart::class => Cart::class,
            CartItem::class => CartItem::class,
            Customer::class => Customer::class,
            Shipping::class => Shipping::class,
            JobOrder::class => JobOrder::class,
            JobItem::class => JobItem::class,

            // Filters
            LoginFilter::class => LoginFilter::class,
            RegisterFilter::class => RegisterFilter::class,
            AddToCartFilter::class => AddToCartFilter::class,
            ShippingFilter::class => ShippingFilter::class,
        )
    ),
);
