<?php

namespace Site\Service;

use Site\Model\CartTable;
use Site\Model\CartItemTable;
use Site\Model\ProductTable;
use Zend\Session\Container;

class CartService
{
    protected $SessionContainer;
    protected $CartTable;
    protected $CartItemTable;
    protected $ProductTable;
    protected $AddToCartFilter;

    public function __construct(
        CartTable $cartTable,
        CartItemTable $cartItemTable,
        ProductTable $productTable
    ) {
        $this->CartTable = $cartTable;
        $this->CartItemTable = $cartItemTable;
        $this->ProductTable = $productTable;
        $this->SessionContainer = new Container('user');
    }

    public function getCart($customerId)
    {
        $cart = $this->CartTable->getCartByCustomerId($customerId);
        $cartArray = null;
        $cartItems = array();
        if ($cart) {
            $cartArray = $cart->getArrayCopy();
            $cartItems = $this->CartItemTable->getCartItems($cartArray['cart_id']);
        }
        return array(
            'cart'  => $cartArray,
            'items' => $cartItems
        );
    }
    
    public function computeCartTotals($cartId)
    {
        $subtotal = 0;
        $taxableAmount = 0;
        $discount = 0;
        $tax = 0;
        $taxRate = 10;
        $shippingTotal = 0;
        $totalAmount = 0;
        $totalWeight = 0;
        $cartItems = $this->CartItemTable->getCartItems($cartId);
        
        foreach ($cartItems as $item) {
            $price = (float) $item['price'];
            $subtotal += $price;
            $taxableAmount += ($item['taxable_flag'] == "y" ? $price : 0);
            $totalWeight += (float) $item['weight'];
        }
        $tax = $taxableAmount * ($taxRate / 100);
        $totalAmount = $subtotal + $tax + $shippingTotal;
        
        return array(
            'sub_total' => $subtotal,
            'taxable_amount' => $taxableAmount,
            'discount' => $discount,
            'tax' => $tax,
            'shipping_total' => $shippingTotal,
            'total_amount' => $totalAmount,
            'total_weight' => $totalWeight
        );
    }
}