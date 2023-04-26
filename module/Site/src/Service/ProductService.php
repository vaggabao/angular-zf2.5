<?php

namespace Site\Service;

use Site\Model\ProductTable;

class ProductService
{
    protected $ProductTable;

    public function __construct(ProductTable $productTable) {
        $this->ProductTable = $productTable;
    }
    
    public function getProductList()
    {
        return $this->ProductTable->getProducts();
    }

    public function getProduct($productId)
    {
        return $this->ProductTable->getProduct($productId)->getArrayCopy();
    }
}