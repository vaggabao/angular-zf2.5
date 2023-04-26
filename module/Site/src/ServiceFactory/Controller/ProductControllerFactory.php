<?php

namespace Site\ServiceFactory\Controller;

use Site\Controller\ProductController;
use Site\Service\ProductService;
use Psr\Container\ContainerInterface;

class ProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        
        $productService = $container->get(ProductService::class);
        return new ProductController($productService);
    }
}
