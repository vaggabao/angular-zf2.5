<?php

namespace Site\Model;

use Zend\Db\TableGateway\TableGateway;

class CustomerTable extends AbstractTable
{
    protected $TableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->TableGateway = $tableGateway;
    }

    public function getCustomerById($customerId)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'customer_id' => $customerId,
        ));
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function getCustomerByEmailPassword($email, $password)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'email' => $email,
            'password' => $password,
        ));
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function getCustomerByEmail($email)
    {
        $select = $this->TableGateway->getSql()->select();
        $select->where(array(
            'email' => $email
        ));
        $resultSet = $this->TableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function insertCustomer($data)
    {
        try {
            $this->TableGateway->insert($data);

            return array(
                'success'     => true,
                'message'     => 'Insert Successful',
                'customer_id' => $this->TableGateway->getLastInsertValue()
            );
        } catch (\Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
}