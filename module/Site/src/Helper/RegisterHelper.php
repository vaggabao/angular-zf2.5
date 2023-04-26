<?php

namespace Site\Helper;

use Site\Model\CustomerTable;
use Zend\Session\Container;

class RegisterHelper
{
    protected $SessionContainer;
    protected $CustomerTable;

    public function __construct(CustomerTable $customerTable)
    {
        $this->CustomerTable = $customerTable;
        $this->SessionContainer = new Container('user');
    }

    public function register($data)
    {
        if ($this->CustomerTable->getCustomerByEmail($data['email'])) {
            return array(
                'success' => 0,
                'errors' => array(
                    'email' => array(
                        'alreadyUsed' => "Email already used"
                    )
                )
            );
        }
        if ($data['password'] !== $data['confirm_password']) {
            return array(
                'success' => 0,
                'errors' => array(
                    'confirm_password' => array(
                        'doesNotMatch' => "Confirm Password does not match with Password"
                    )
                )
            );
        }

        unset($data['confirm_password']);
        $insert = $this->CustomerTable->insertCustomer($data);
        $this->SessionContainer->login_status = 1;
        $this->SessionContainer->customer_id = $insert['customer_id'];

        return array(
            'success' => 1,
            'errors' => array()
        );
    }
}