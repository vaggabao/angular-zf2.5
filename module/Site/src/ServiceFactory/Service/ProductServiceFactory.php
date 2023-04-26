<?php

namespace Site\ServiceFactory\Service;

use Site\Service\ProductService;
use Site\Model\ProductTable;
use Psr\Container\ContainerInterface;

class ProductServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $productTable = $container->get(ProductTable::class);

        return new ProductService($productTable);
    }
}