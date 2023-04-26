<?php

namespace Site\ServiceFactory\Helper;

use Site\Helper\RegisterHelper;
use Site\Model\CustomerTable;
use Psr\Container\ContainerInterface;

class RegisterHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $customerTable = $container->get(CustomerTable::class);

        return new RegisterHelper($customerTable);
    }
}