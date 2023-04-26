<?php

namespace Site\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Site\Model\JobItemTable;
use Site\Model\JobItem;
use Site\ServiceFactory\Model\AbstractModelFactory;

class JobItemTableFactory extends AbstractModelFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('zf_exam');
        $tableGateway = $this->initializeTableGateway(
            array('ji' => 'job_items'),
            $dbAdapter,
            null,
            new JobItem()
        );
        return new JobItemTable($tableGateway, $dbAdapter);
    }
}