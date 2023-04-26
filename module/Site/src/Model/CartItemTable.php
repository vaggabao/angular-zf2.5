<?php

namespace Site\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class CartItemTable extends AbstractTable
{
    protected $TableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->TableGateway = $tableGateway;
    }

    public function getCartItems($cartId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->join(
            array(
                'p' => 'products'
            ),
            'c.product_id = p.product_id',
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
            'cart_id' => $cartId
        ));
        
        $dataSource = $this->TableGateway->selectWith($select)->getDataSource();
        if ($dataSource->count() > 0) {
            $resultSet = new ResultSet();
            $resultSet->initialize($dataSource);
            return $resultSet->toArray();
        }
        return array();
    }

    public function getCartItem($cartId, $productId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'cart_id' => $cartId,
            'product_id' => $productId
        ));
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function insertCartItem($insertData)
    {
        $affectedRows = $this->TableGateway->insert($insertData);
        return $this->TableGateway->getLastInsertValue();
    }

    public function updateCartItem($cartItemId, $updateData)
    {
        $affectedRows = $this->TableGateway->update($updateData, array(
            'cart_item_id' => $cartItemId
        ));
        return $affectedRows;
    }

    public function deleteCartItems($cartId)
    {
        $affectedRows = $this->TableGateway->delete(array(
            'cart_id' => $cartId,
        ));
        return $affectedRows;
    }
}