<?php

namespace Site\Helper;

use Site\Model\CartTable;
use Site\Model\CartItemTable;
use Site\Model\ProductTable;
use Site\Model\CustomerTable;
use Site\Service\CartService;
use Site\Service\ShippingService;
use Zend\Session\Container;

class CartHelper
{
    protected $SessionContainer;
    protected $CartTable;
    protected $CartItemTable;
    protected $ProductTable;
    protected $CustomerTable;
    protected $CartService;
    protected $ShippingService;

    public function __construct(
        CartTable $cartTable,
        CartItemTable $cartItemTable,
        ProductTable $productTable,
        CustomerTable $customerTable,
        CartService $cartService,
        ShippingService $shippingService
    ) {
        $this->CartTable = $cartTable;
        $this->CartItemTable = $cartItemTable;
        $this->ProductTable = $productTable;
        $this->CustomerTable = $customerTable;
        $this->CartService = $cartService;
        $this->ShippingService = $shippingService;
        $this->SessionContainer = new Container('user');
    }

    public function getCart()
    {
        $loginStatus = $this->SessionContainer->login_status ?: 0;
        if ($loginStatus === 0) {
            $getCart = $this->CartService->getCart(0);
        } else {
            $customerId = $this->SessionContainer->customer_id;
            $getCart = $this->CartService->getCart($customerId);
        }
        $cart = $getCart['cart'];
        $cartItems = $getCart['items'];

        return array(
            'items' => $cartItems,
            'subtotal' => (float) $cart['sub_total'],
            'shipping' => (float) $cart['shipping_total'],
            'grand_total' => (float) $cart['total_amount'],
            'total_weight' => (float) $cart['total_weight'],
        );
    }

    public function addToCart($productId, $qty)
    {
        $loginStatus = $this->SessionContainer->login_status ?: 0;
        $product = $this->ProductTable->getProduct($productId);
        if ($product) {
            if ($loginStatus === 0) {
                $customerId = 0;
            } else {
                $customerId = $this->SessionContainer->customer_id;
            }

            $cart = $this->CartTable->getCartByCustomerId($customerId);
            if ($cart) {
                $cartItem = $this->CartItemTable->getCartItem($cart->cart_id, $productId);
                if ($cartItem) {
                    // Cart item already exists
                    // Update cart item
                    $newQty = (int) $qty + (int) $cartItem->qty;
                    if ($newQty > (int) $product->stock_qty) {
                        $newQty = (int) $product->stock_qty;
                    }
                    $newWeight = (int) $product->weight * $newQty;
                    $price = (float) $product->price;
                    $newPrice = $price * $newQty;
                    $updateData = array(
                        'weight' => $newWeight,
                        'qty' => $newQty,
                        'unit_price' => $price,
                        'price' => $newPrice
                    );
                    $update = $this->CartItemTable->updateCartItem($cartItem->cart_item_id, $updateData);
                    return 1;
                } else {
                    // Cart item does not exists
                    // Insert cart item
                    if ($qty > (int) $product->stock_qty) {
                        $qty = (int) $product->stock_qty;
                    }
                    $weight = (float) $product->weight * (int) $qty;
                    $price = (float) $product->price;
                    $totalPrice = $price * (int) $qty;
                    $insertData = array(
                        'cart_id' => $cart->cart_id,
                        'product_id' => (int) $productId,
                        'weight' => $weight,
                        'qty' => (int) $qty,
                        'unit_price' => $price,
                        'price' => $totalPrice
                    );
                    $insert = $this->CartItemTable->insertCartItem($insertData);
                    
                    // Update cart totals
                    $cartTotals = $this->CartService->computeCartTotals($cart->cart_id);
                    $this->CartTable->updateCart($cart->cart_id, $cartTotals);

                    return 1;
                }
            } else {
                // Cart does not exists
                // Create cart and cart item
                if ($customerId !== 0) {
                    $customer = $this->CustomerTable->getCustomerById($customerId);
                    $insertData = array(
                        'customer_id' => $customerId,
                        'order_datetime' => date('Y-m-d H:i:s'),
                        'email' => $customer->email,
                        'first_name' => $customer->first_name,
                        'last_name' => $customer->last_name,
                        'phone' => $customer->phone,
                    );
                } else {
                    $insertData = array(
                        'customer_id' => $customerId,
                        'order_datetime' => date('Y-m-d H:i:s')
                    );
                }
                $insertCart = $this->CartTable->insertCart($insertData);
                $cartId = $insertCart['cart_id'];
                
                if ($qty > (int) $product->stock_qty) {
                    $qty = (int) $product->stock_qty;
                }
                $weight = (float) $product->weight * (int) $qty;
                $price = (float) $product->price;
                $totalPrice = $price * (int) $qty;
                $insertData = array(
                    'cart_id' => $cartId,
                    'product_id' => (int) $productId,
                    'weight' => $weight,
                    'qty' => (int) $qty,
                    'unit_price' => $price,
                    'price' => $totalPrice
                );
                $insertCartItem = $this->CartItemTable->insertCartItem($insertData);

                // Update cart totals
                $cartTotals = $this->CartService->computeCartTotals($cartId);
                $this->CartTable->updateCart($cartId, $cartTotals);

                return 1;
            }
        }

        return 0;
    }

    public function associateLogoutCart()
    {
        $customerId = $this->SessionContainer->customer_id;
        $logoutCart = $this->CartTable->getCartByCustomerId(0);
        if ($logoutCart) {
            $existingCart = $this->CartTable->getCartByCustomerId($customerId);
            if ($existingCart) {
                // Delete existing cart
                $this->CartTable->deleteCart($existingCart->cart_id);
                // Delete existing cart items
                $this->CartItemTable->deleteCartItems($existingCart->cart_id);
            }

            $customer = $this->CustomerTable->getCustomerById($customerId);
            // Update logout cart
            $this->CartTable->updateCart($logoutCart->cart_id, array(
                'customer_id' => $customerId,
                'company_name' => $customer->company_name,
                'email' => $customer->email,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone' => $customer->phone,
            ));
        }
    }

    public function saveShippingDetails($data)
    {
        $customerId = $this->SessionContainer->customer_id;
        $cart = $this->CartTable->getCartByCustomerId($customerId);
        if ($cart) {
            $cartArray = $cart->getArrayCopy();
            $cartId = $cartArray['cart_id'];
            $cartTotals = $this->CartService->computeCartTotals($cartId);

            $shippingTotal = $this->ShippingService->getShippingAmount(
                $cartTotals['total_weight'],
                $data['shipping_method']
            );
            $totalAmount = $cartTotals['total_amount'] + $shippingTotal;

            // Update cart
            $updateData = array(
                'shipping_total'    => $shippingTotal,
                'total_amount'      => $totalAmount,
                'shipping_mehod'    => $data['shipping_method'],
                'shipping_name'     => $data['name'],
                'shipping_address1' => $data['address1'],
                'shipping_address2' => $data['address2'],
                'shipping_address3' => $data['address3'],
                'shipping_city'     => $data['city'],
                'shipping_state'    => $data['state'],
                'shipping_country'  => $data['country'],
            );
            $updateCart = $this->CartTable->updateCart($cartId, $updateData);
            return 1;
        }

        return 0;
    }
}