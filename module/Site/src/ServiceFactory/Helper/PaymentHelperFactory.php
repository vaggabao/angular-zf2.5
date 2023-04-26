<?php

namespace Site\ServiceFactory\Helper;

use Site\Helper\PaymentHelper;
use Site\Model\CartTable;
use Site\Model\CartItemTable;
use Site\Model\JobOrderTable;
use Site\Model\JobItemTable;
use Site\Model\ProductTable;
use Psr\Container\ContainerInterface;

class PaymentHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cartTable = $container->get(CartTable::class);
        $cartItemTable = $container->get(CartItemTable::class);
        $jobOrderTable = $container->get(JobOrderTable::class);
        $jobItemTable = $container->get(JobItemTable::class);
        $productTable = $container->get(ProductTable::class);

        return new PaymentHelper(
            $cartTable,
            $cartItemTable,
            $jobOrderTable,
            $jobItemTable,
            $productTable
        );
    }
}