<?php

namespace Site\ServiceFactory\Helper;

use Site\Helper\CartHelper;
use Site\Model\CartTable;
use Site\Model\CartItemTable;
use Site\Model\ProductTable;
use Site\Model\CustomerTable;
use Site\Service\CartService;
use Site\Service\ShippingService;
use Psr\Container\ContainerInterface;

class CartHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cartTable = $container->get(CartTable::class);
        $cartItemTable = $container->get(CartItemTable::class);
        $productTable = $container->get(ProductTable::class);
        $customerTable = $container->get(CustomerTable::class);
        $cartService = $container->get(CartService::class);
        $shippingService = $container->get(ShippingService::class);

        return new CartHelper(
            $cartTable,
            $cartItemTable,
            $productTable,
            $customerTable,
            $cartService,
            $shippingService
        );
    }
}