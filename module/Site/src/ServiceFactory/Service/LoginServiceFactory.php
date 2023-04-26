<?php

namespace Site\ServiceFactory\Service;

use Site\Service\LoginService;
use Site\Model\CustomerTable;
use Psr\Container\ContainerInterface;

class LoginServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $customerTable = $container->get(CustomerTable::class);

        return new LoginService($customerTable);
    }
}
