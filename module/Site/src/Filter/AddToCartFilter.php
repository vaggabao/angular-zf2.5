<?php

namespace Site\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class AddToCartFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'     => 'product_id',
            'required' => true,
            'filters'  => array(
                array('name' => 'Int'),
            ),
            'validators' => array(
                array('name' => 'Digits'),
            ),
        ));
        $this->add(array(
            'name'     => 'qty',
            'required' => true,
            'filters'  => array(
                array('name' => 'Int'),
            ),
            'validators' => array(
                array('name' => 'Digits'),
            ),
        ));
    }
}