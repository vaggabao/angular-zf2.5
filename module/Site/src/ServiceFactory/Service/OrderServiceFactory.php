<?php

namespace Site\ServiceFactory\Service;

use Site\Service\OrderService;
use Site\Model\JobOrderTable;
use Site\Model\JobItemTable;
use Psr\Container\ContainerInterface;

class OrderServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $jobOrderTable = $container->get(JobOrderTable::class);
        $jobItemTable = $container->get(JobItemTable::class);

        return new OrderService($jobOrderTable, $jobItemTable);
    }
}
