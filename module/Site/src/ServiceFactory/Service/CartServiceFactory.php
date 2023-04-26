<?php

namespace Site\ServiceFactory\Service;

use Site\Service\CartService;
use Site\Model\CartTable;
use Site\Model\CartItemTable;
use Site\Model\ProductTable;
use Psr\Container\ContainerInterface;

class CartServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cartTable = $container->get(CartTable::class);
        $cartItemTable = $container->get(CartItemTable::class);
        $productTable = $container->get(ProductTable::class);

        return new CartService($cartTable, $cartItemTable, $productTable);
    }
}
