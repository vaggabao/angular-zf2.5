<?php

namespace Site\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Site\Model\JobOrderTable;
use Site\Model\JobOrder;
use Site\ServiceFactory\Model\AbstractModelFactory;

class JobOrderTableFactory extends AbstractModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('zf_exam');
        $tableGateway = $this->initializeTableGateway(
            'job_orders',
            $dbAdapter,
            null,
            new JobOrder()
        );
        return new JobOrderTable($tableGateway);
    }
}