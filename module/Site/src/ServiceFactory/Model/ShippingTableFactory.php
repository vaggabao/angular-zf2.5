<?php

namespace Site\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Site\Model\ShippingTable;
use Site\Model\Shipping;
use Site\ServiceFactory\Model\AbstractModelFactory;

class ShippingTableFactory extends AbstractModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('zf_exam');
        $tableGateway = $this->initializeTableGateway(
            array('s' => 'shipping'),
            $dbAdapter,
            null,
            new Shipping()
        );
        return new ShippingTable($tableGateway);
    }
}