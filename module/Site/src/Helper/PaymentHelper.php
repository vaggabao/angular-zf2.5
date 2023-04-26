<?php

namespace Site\Helper;

use Site\Model\CartTable;
use Site\Model\CartItemTable;
use Site\Model\JobOrderTable;
use Site\Model\JobItemTable;
use Site\Model\ProductTable;
use Zend\Session\Container;

class PaymentHelper
{
    protected $SessionContainer;
    protected $CartTable;
    protected $CartItemTable;
    protected $JobOrderTable;
    protected $JobItemTable;
    protected $ProductTable;

    public function __construct(
        CartTable $cartTable,
        CartItemTable $cartItemTable,
        JobOrderTable $jobOrderTable,
        JobItemTable $jobItemTable,
        ProductTable $productTable
    ) {
        $this->CartTable = $cartTable;
        $this->CartItemTable = $cartItemTable;
        $this->JobOrderTable = $jobOrderTable;
        $this->JobItemTable = $jobItemTable;
        $this->ProductTable = $productTable;
        $this->SessionContainer = new Container('user');
    }

    public function createJobOrder()
    {
        $customerId = $this->SessionContainer->customer_id;
        $cart = $this->CartTable->getCartByCustomerId($customerId);
        if ($cart) {
            $jobOrder = $cart->getArrayCopy();
            unset($jobOrder['cart_id']);

            // Insert job order
            $jobOrderInsert = $this->JobOrderTable->insertJobOrder($jobOrder);
            $jobOrderId = $jobOrderInsert['job_order_id'];

            $cartItems = $this->CartItemTable->getCartItems($cart->cart_id);
            $jobItems = array();
            $productStockQtyUpdate = array();
            foreach ($cartItems as $cartItem) {
                $productId = $cartItem['product_id'];
                $newStockQty = $this->ProductTable->getProductStockQty($productId) - (int) $cartItem['qty'];
                $productStockQtyUpdate[] = array(
                    'product_id' => $productId,
                    'data'       => array(
                        'stock_qty' => $newStockQty
                    )
                );
                $jobItems[] = array(
                    'job_order_id' => $jobOrderId,
                    'product_id' => $productId,
                    'weight' => $cartItem['weight'],
                    'qty' => $cartItem['qty'],
                    'unit_price' => $cartItem['unit_price'],
                    'price' => $cartItem['price']
                );
            }
            // Insert job order items
            $jobItemInsert = $this->JobItemTable->insertBatch($jobItems);

            // Update products stock qty
            $this->ProductTable->updateProductStockQtyBatch($productStockQtyUpdate);
            
            // Delete current cart
            $this->CartTable->deleteCart($cart->cart_id);
            // Delete current cart items
            $this->CartItemTable->deleteCartItems($cart->cart_id);
            
            return $jobOrderId;
        }
    }
}