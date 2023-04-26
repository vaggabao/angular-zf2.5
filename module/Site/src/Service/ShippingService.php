<?php

namespace Site\Service;

use Site\Model\ShippingTable;

class ShippingService
{
    protected $SessionContainer;
    protected $ShippingTable;
    protected $CartItemTable;
    protected $ProductTable;
    protected $AddToCartFilter;

    public function __construct(ShippingTable $shippingTable) {
        $this->ShippingTable = $shippingTable;
    }

    public function getShippingAmount($weight, $shippingMethod)
    {    
        $maxWeight = $this->ShippingTable->getMaxShippingWeight($shippingMethod);
        $shippingCount = ceil($weight / $maxWeight);
        $shippingAmount = 0;
        for ($shippingIndex = 0; $shippingIndex < $shippingCount; $shippingIndex++) {
            $remainingWeight = $weight - ($maxWeight * $shippingIndex);
            if ($remainingWeight > $maxWeight) {
                $remainingWeight = $maxWeight;
            }
            $shippingAmount += $this->ShippingTable->getShippingRate($remainingWeight, $shippingMethod);
        }
        
        return $shippingAmount;
    }
}