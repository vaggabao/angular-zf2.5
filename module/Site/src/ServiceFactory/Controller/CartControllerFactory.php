<?php

namespace Site\ServiceFactory\Controller;

use Site\Controller\CartController;
use Site\Helper\CartHelper;
use Site\Filter\AddToCartFilter;
use Psr\Container\ContainerInterface;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        
        $cartHelper = $container->get(CartHelper::class);
        $addToCartFilter = $container->get(AddToCartFilter::class);
        
        return new CartController($cartHelper, $addToCartFilter);
    }
}
