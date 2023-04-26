<?php

namespace Site\Model;

use Zend\Db\TableGateway\TableGateway;

class JobOrderTable extends AbstractTable
{
    protected $TableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->TableGateway = $tableGateway;
    }

    public function getJobOrder($jobOrderId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'job_order_id' => $jobOrderId
        ));
        $resultSet = $this->TableGateway->selectWith($select);
        
        return $resultSet->current();
    }

    public function insertJobOrder($data)
    {
        try {
            $this->TableGateway->insert($data);

            return array(
                'success' => true,
                'job_order_id' => $this->TableGateway->getLastInsertValue(),
                'message' => 'Insert Successful'
            );
        } catch (\Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
}