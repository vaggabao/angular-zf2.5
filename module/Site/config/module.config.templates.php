<?php
return array(
    'view_manager' => array(
        'layout'                   => (in_array(getenv('APPLICATION_ENV'), array('aws','aws-qa'))) ? 'error/404' : 'error/404',
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => (getenv('APPLICATION_ENV') == 'local') ? 'error/404' : 'error/404',
        'template_map' => array(
            'MAIN_TPL' => __DIR__ . '/../view/layout/main-tpl.phtml',
            // View
            'HOMEPAGE' =>  __DIR__ . '/../view/site/homepage.phtml',
            'PRODUCT' =>  __DIR__ . '/../view/site/product.phtml',
            'CART' =>  __DIR__ . '/../view/site/cart.phtml',
            'SHIPPING' =>  __DIR__ . '/../view/site/shipping.phtml',
            'PAYMENT' =>  __DIR__ . '/../view/site/payment.phtml',
            'ORDER' =>  __DIR__ . '/../view/site/order.phtml',
            'LOGIN' =>  __DIR__ . '/../view/site/login.phtml',
            // Partial
            'HEADER' => __DIR__ . '/../view/partials/header.phtml',
            'HOME_PRODUCT_DETAILS' => __DIR__ . '/../view/partials/home-product-details.phtml',
            'CART_ITEM' => __DIR__ . '/../view/partials/cart-item.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
