<?php

namespace Site\Service;

use Site\Model\JobOrderTable;
use Site\Model\JobItemTable;

class OrderService
{
    protected $JobOrderTable;
    protected $JobItemTable;

    public function __construct(
        JobOrderTable $jobOrderTable,
        JobItemTable $jobItemTable
    ) {
        $this->JobOrderTable = $jobOrderTable;
        $this->JobItemTable = $jobItemTable;
    }
    
    public function getJobOrder($jobOrderId)
    {
        return $this->JobOrderTable->getJobOrder($jobOrderId);
    }

    public function getJobOrderItems($jobOrderId)
    {
        return $this->JobItemTable->getJobItems($jobOrderId);
    }
}