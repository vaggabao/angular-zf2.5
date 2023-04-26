<?php

namespace Site\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\Expression;

class ShippingTable extends AbstractTable
{
    protected $TableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->TableGateway = $tableGateway;
    }

    public function getShippingList()
    {
        $select = $this->TableGateway->getSql()->select();
        $resultSet = $this->TableGateway->selectWith($select);
        
        return $resultSet->toArray();
    }

    public function getShippingRate($weight, $shippingMethod)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'shipping_method' => $shippingMethod,
            new Expression('? BETWEEN min_weight AND max_weight', $weight)
        ));
        $dataSource = $this->TableGateway->selectWith($select)->getDataSource();
        if ($dataSource->count() > 0) {
            return (float) $dataSource->current()['shipping_rate'];
        }
        return 0;
    }

    public function getMaxShippingWeight($shippingMethod)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->columns(array(
            'max_weight' => new Expression('MAX(max_weight)')
        ));
        $select->where(array(
            'shipping_method' => $shippingMethod,
        ));
        $resultSet = $this->TableGateway->selectWith($select);
        $row = $resultSet->current();

        return (float) $row->max_weight;
    }
}