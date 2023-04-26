<?php

namespace Site\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class ShippingFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'     => 'name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Name is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min'      => 1,
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooShort' => 'Name is too short.',
                            'stringLengthTooLong'  => 'Name is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'address1',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Address 1 is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooLong'  => 'Address 1 is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'address2',
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooLong'  => 'Address 2 is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'address3',
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooLong'  => 'Address 3 is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'city',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'City is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooLong'  => 'City is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'state',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'State is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooLong'  => 'State is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'country',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Country is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooLong'  => 'Country is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'shipping_method',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Shipping Method is required.',
                        ),
                    ),
                ),
            ),
        ));
    }
}