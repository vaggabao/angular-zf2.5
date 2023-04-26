<?php

namespace Site\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Site\Model\CartTable;
use Site\Model\Cart;
use Site\ServiceFactory\Model\AbstractModelFactory;

class CartTableFactory extends AbstractModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('zf_exam');
        $tableGateway = $this->initializeTableGateway(
            'carts',
            $dbAdapter,
            null,
            new Cart()
        );
        return new CartTable($tableGateway);
    }
}