<?php

namespace Site\Service;

use Site\Model\CustomerTable;
use Zend\Session\Container;

class LoginService
{
    protected $SessionContainer;
    protected $CustomerTable;

    public function __construct(CustomerTable $customerTable) {
        $this->CustomerTable = $customerTable;
        $this->SessionContainer = new Container('user');
    }

    public function checkLoginStatus()
    {
        $loginStatus = $this->SessionContainer->login_status ?: 0;
        return $loginStatus;
    }

    public function getLoggedInCustomer()
    {
        $customerId = $this->SessionContainer->customer_id ?: null;
        if ($customerId) {
            return $this->CustomerTable->getCustomerById($customerId)->getArrayCopy();
        }

        return null;
    }

    public function login($data)
    {
        $customer = $this->CustomerTable->getCustomerByEmailPassword($data['email'], $data['password']);
        if ($customer) {
            $this->SessionContainer->login_status = 1;
            $this->SessionContainer->customer_id = $customer->customer_id;
            return array(
                'success' => 1,
                'errors'  => array()
            );
        }

        $this->SessionContainer->login_status = 0;
        $this->SessionContainer->customer_id = null;
        return array(
            'success' => 0,
            'errors'  => array(
                'login' => array(
                    'invalidAccount' => 'Account does not exists'
                )
            )
        );
    }

    public function logout()
    {
        $this->SessionContainer->getManager()->getStorage()->clear('user');
    }
}