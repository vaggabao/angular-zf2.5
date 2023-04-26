<?php

namespace Site\Model;

use Zend\Db\Adapter\Driver\ConnectionInterface;
use Zend\Db\TableGateway\TableGateway;

class ProductTable extends AbstractTable
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

    public function getProducts()
    {
        $select = $this->TableGateway->getSql()->select();
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->toArray();
    }

    public function getProduct($productId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'product_id' => $productId
        ));
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function getProductStockQty($productId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'product_id' => $productId
        ));
        $resultSet = $this->TableGateway->selectWith($select);
        if ($resultSet->current()) {
            return (int) $resultSet->current()->stock_qty;
        }

        return 0;
    }

    public function updateProductStockQtyBatch($data)
    {
        try {
            $connection = $this->DbAdapter->getDriver()->getConnection();

            if (!empty($data)) {
                $connection->beginTransaction();

                foreach ($data as $updateData) {
                    $this->TableGateway->update($updateData['data'], array(
                        'product_id' => $updateData['product_id']
                    ));
                }

                $connection->commit();

                return array(
                    'success' => true,
                    'message' => "Update batch successful"
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
}