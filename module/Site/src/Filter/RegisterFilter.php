<?php

namespace Site\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class RegisterFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'     => 'email',
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
                            NotEmpty::IS_EMPTY => 'Email is required.',
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'password',
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
                            NotEmpty::IS_EMPTY => 'Password is required.',
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'confirm_password',
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
                            NotEmpty::IS_EMPTY => 'Confirm Password is required.',
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'company_name',
            'required' => false,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Company Name is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooLong' => 'Company Name is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'first_name',
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
                            NotEmpty::IS_EMPTY => 'First Name is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min'      => 1,
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooShort' => 'First Name is too short.',
                            'stringLengthTooLong'  => 'First Name is too long.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'     => 'last_name',
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
                            NotEmpty::IS_EMPTY => 'Last Name is required.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min'      => 1,
                        'max'      => 35,
                        'messages' => array(
                            'stringLengthTooShort' => 'Last Name is too short.',
                            'stringLengthTooLong'  => 'Last Name is too long.'
                        ),
                    ),
                ),
            ),
        ));
    }
}