<?php

namespace Site\Model;

use Zend\Db\TableGateway\TableGateway;

class CartTable extends AbstractTable
{
    protected $TableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->TableGateway = $tableGateway;
    }

    public function getCartList()
    {
        $select = $this->TableGateway->getSql()->select();
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->toArray();
    }

    public function getCartByCustomerId($customerId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'customer_id' => $customerId
        ));
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function insertCart($insertData)
    {
        try {
            $this->TableGateway->insert($insertData);

            return array(
                'success' => true,
                'message' => 'Insert Successful',
                'cart_id' => $this->TableGateway->getLastInsertValue()
            );
        } catch (\Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }

    public function updateCart($cartId, $updateData)
    {
        try {
            $affectedRows = $this->TableGateway->update($updateData, array(
                'cart_id' => $cartId
            ));

            return array(
                'success'       => true,
                'message'       => 'Update Successful',
                'affected_rows' => $affectedRows
            );
        } catch (\Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }

    public function deleteCart($cartId)
    {
        try {
            $affectedRows = $this->TableGateway->delete(array(
                'cart_id' => $cartId
            ));

            return array(
                'success'       => true,
                'message'       => 'Delete Successful',
                'affected_rows' => $affectedRows
            );
        } catch (\Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
}