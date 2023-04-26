<?php

namespace Site\Model;

use Zend\Db\Adapter\Driver\ConnectionInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class JobItemTable extends AbstractTable
{
    protected $TableGateway;
    protected $DbAdapter;

    public function __construct(
        TableGateway $tableGateway,
        $DbAdapter
    ) {
        $this->TableGateway = $tableGateway;
        $this->DbAdapter = $DbAdapter;
    }

    public function getJobItems($jobOrderid)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->join(
            array(
                'p' => 'products'
            ),
            'ji.product_id = p.product_id',
            array(
                'product_name',
                'product_desc',
                'product_image',
                'product_thumbnail',
                'product_weight' => 'weight',
                'product_price' => 'price',
                'stock_qty',
                'taxable_flag',
            ),
            Select::JOIN_LEFT
        );
        $select->where(array(
            'job_order_id' => $jobOrderid
        ));
        
        $dataSource = $this->TableGateway->selectWith($select)->getDataSource();
        if ($dataSource->count() > 0) {
            $resultSet = new ResultSet();
            $resultSet->initialize($dataSource);
            return $resultSet->toArray();
        }
        return array();
    }

    public function getJobItem($jobOrderid, $productId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'job_order_id' => $jobOrderid,
            'product_id' => $productId
        ));
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function insertBatch($data)
    {
        try {
            $connection = $this->DbAdapter->getDriver()->getConnection();

            if (!empty($data)) {
                $connection->beginTransaction();

                foreach ($data as $jobItem) {
                    $this->TableGateway->insert($jobItem);
                }

                $connection->commit();

                return array(
                    'success' => true,
                    'message' => "Insert batch successful"
                );
            }
        } catch (\Exception $e) {
            if ($connection instanceof ConnectionInterface) {
                $connection->rollback();
            }

            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }

    public function updateJobItem($jobItemId, $updateData)
    {
        $affectedRows = $this->TableGateway->update($updateData, array(
            'job_item_id' => $jobItemId
        ));
        return $affectedRows;
    }

    public function deleteJobItems($jobOrderid)
    {
        $affectedRows = $this->TableGateway->delete(array(
            'job_order_id' => $jobOrderid,
        ));
        return $affectedRows;
    }
}