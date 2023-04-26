<?php

namespace Site\ServiceFactory\Controller;

use Site\Controller\OrderController;
use Site\Service\LoginService;
use Site\Service\OrderService;
use Psr\Container\ContainerInterface;

class OrderControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $loginService = $container->get(LoginService::class);
        $orderService = $container->get(OrderService::class);
        
        return new OrderController($loginService, $orderService);
    }
}
