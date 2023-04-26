<?php

namespace Site\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Site\Model\CartItemTable;
use Site\Model\CartItem;
use Site\ServiceFactory\Model\AbstractModelFactory;

class CartItemTableFactory extends AbstractModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('zf_exam');
        $tableGateway = $this->initializeTableGateway(
            array('c' => 'cart_items'),
            $dbAdapter,
            null,
            new CartItem()
        );
        return new CartItemTable($tableGateway);
    }
}