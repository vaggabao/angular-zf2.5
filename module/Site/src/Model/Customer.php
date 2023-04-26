<?php

namespace Site\Model;

class Customer
{
    public $customer_id;
    public $email;
    // public $password;
    public $company_name;
    public $first_name;
    public $last_name;
    public $phone;

    public function exchangeArray($data)
    {
        $this->customer_id = (!empty($data["customer_id"])) ? $data["customer_id"] : null;
        $this->email = (!empty($data["email"])) ? $data["email"] : null;
        // $this->password = (!empty($data["password"])) ? $data["password"] : null;
        $this->company_name = (!empty($data["company_name"])) ? $data["company_name"] : null;
        $this->first_name = (!empty($data["first_name"])) ? $data["first_name"] : null;
        $this->last_name = (!empty($data["last_name"])) ? $data["last_name"] : null;
        $this->phone = (!empty($data["phone"])) ? $data["phone"] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}