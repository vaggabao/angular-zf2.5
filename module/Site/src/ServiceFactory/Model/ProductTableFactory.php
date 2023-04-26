<?php

namespace Site\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Site\Model\ProductTable;
use Site\Model\Product;
use Site\ServiceFactory\Model\AbstractModelFactory;

class ProductTableFactory extends AbstractModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('zf_exam');
        $tableGateway = $this->initializeTableGateway(
            'products',
            $dbAdapter,
            null,
            new Product()
        );
        return new ProductTable($tableGateway, $dbAdapter);
    }
}