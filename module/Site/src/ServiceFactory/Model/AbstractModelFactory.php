<?php

namespace Site\ServiceFactory\Model;

use Site\Model\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\MasterSlaveFeature;

class AbstractModelFactory
{

    protected function initializeTableGateway(
        $tableName,
        $dbAdapter,
        $slaveDbAdapter = null,
        $model
    ) {
        if (!empty($slaveDbAdapter) && $slaveDbAdapter instanceof Adapter) {
            $slaveDbAdapter = new MasterSlaveFeature($slaveDbAdapter);
        }

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($model);
        return new AbstractTableGateway($tableName, $dbAdapter, $slaveDbAdapter, $resultSetPrototype);
    }
}
