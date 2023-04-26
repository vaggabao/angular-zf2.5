<?php

namespace Site\ServiceFactory\Controller;

use Site\Controller\ShippingController;
use Site\Service\LoginService;
use Site\Service\ShippingService;
use Site\Helper\CartHelper;
use Site\Filter\ShippingFilter;
use Psr\Container\ContainerInterface;

class ShippingControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        
        $loginService = $container->get(LoginService::class);
        $shippingService = $container->get(ShippingService::class);
        $cartHelper = $container->get(CartHelper::class);
        $shippingFilter = $container->get(ShippingFilter::class);
        
        return new ShippingController(
            $loginService,
            $shippingService,
            $cartHelper,
            $shippingFilter
        );
    }
}
