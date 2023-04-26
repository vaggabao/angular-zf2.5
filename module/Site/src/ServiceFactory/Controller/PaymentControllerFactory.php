<?php

namespace Site\ServiceFactory\Controller;

use Site\Controller\PaymentController;
use Site\Service\LoginService;
use Site\Helper\PaymentHelper;
use Site\Helper\CartHelper;
use Psr\Container\ContainerInterface;

class PaymentControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        
        $loginService = $container->get(LoginService::class);
        $paymentHelper = $container->get(PaymentHelper::class);
        $cartHelper = $container->get(CartHelper::class);
        
        return new PaymentController(
            $loginService,
            $paymentHelper,
            $cartHelper
        );
    }
}
