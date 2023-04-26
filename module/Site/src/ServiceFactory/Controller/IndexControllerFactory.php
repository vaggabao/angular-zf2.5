<?php

namespace Site\ServiceFactory\Controller;

use Site\Controller\IndexController;
use Site\Service\ProductService;
use Psr\Container\ContainerInterface;

class IndexControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        
        $productService = $container->get(ProductService::class);
        return new IndexController($productService);
    }
}
