<?php

namespace Site\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Site\Model\CustomerTable;
use Site\Model\Customer;
use Site\ServiceFactory\Model\AbstractModelFactory;

class CustomerTableFactory extends AbstractModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('zf_exam');
        $tableGateway = $this->initializeTableGateway(
            array('c' => 'customers'),
            $dbAdapter,
            null,
            new Customer()
        );
        return new CustomerTable($tableGateway);
    }
}