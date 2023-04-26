<?php

namespace Site\ServiceFactory\Service;

use Site\Service\ShippingService;
use Site\Model\ShippingTable;
use Psr\Container\ContainerInterface;

class ShippingServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $shippingTable = $container->get(ShippingTable::class);

        return new ShippingService($shippingTable);
    }
}
