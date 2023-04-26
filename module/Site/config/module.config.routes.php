<?php

use Site\Controller\IndexController;
use Site\Controller\ProductController;
use Site\Controller\CartController;
use Site\Controller\ShippingController;
use Site\Controller\PaymentController;
use Site\Controller\OrderController;
use Site\Controller\LoginController;

return array(
    'router' => array(
        'routes' => array(
            // to be updated in creating page renderer story
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => IndexController::class,
                        'action'        => 'index',
                        'view_template' => 'HOMEPAGE',
                        'template'      => 'MAIN_TPL'
                    ),
                ),
            ),
            'product' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/product/:id',
                    'defaults' => array(
                        'controller'    => ProductController::class,
                        'action'        => 'display',
                        'view_template' => 'PRODUCT',
                        'template'      => 'MAIN_TPL'
                    ),
                ),
            ),
            'cart' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/cart',
                    'defaults' => array(
                        'controller'    => CartController::class,
                        'action'        => 'display',
                        'view_template' => 'CART',
                        'template'      => 'MAIN_TPL'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add-to-cart' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/add-to-cart',
                            'defaults' => array(
                                'action' => 'addToCart'
                            ),
                        )
                    ),
                )
            ),
            'shipping' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/shipping',
                    'defaults' => array(
                        'controller'    => ShippingController::class,
                        'action'        => 'display',
                        'view_template' => 'SHIPPING',
                        'template'      => 'MAIN_TPL'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'save' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/save',
                            'defaults' => array(
                                'action' => 'saveShipping'
                            ),
                        )
                    ),
                )
            ),
            'payment' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/payment',
                    'defaults' => array(
                        'controller'    => PaymentController::class,
                        'action'        => 'display',
                        'view_template' => 'PAYMENT',
                        'template'      => 'MAIN_TPL'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'checkout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/checkout',
                            'defaults' => array(
                                'action' => 'checkout'
                            ),
                        )
                    ),
                )
            ),
            'order' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/order/:id',
                    'defaults' => array(
                        'controller'    => OrderController::class,
                        'action'        => 'display',
                        'view_template' => 'ORDER',
                        'template'      => 'MAIN_TPL'
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller'    => LoginController::class,
                        'action'        => 'display',
                        'view_template' => 'LOGIN',
                        'template'      => 'MAIN_TPL'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'auth' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/auth',
                            'defaults' => array(
                                'action' => 'auth'
                            ),
                        )
                    ),
                )
            ),
            'register' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/register',
                    'defaults' => array(
                        'controller'    => LoginController::class,
                        'action'        => 'register'
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller'    => LoginController::class,
                        'action'        => 'logout'
                    ),
                ),
            ),
        ),
    ),
);