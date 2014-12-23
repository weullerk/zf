<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 23/12/2014
 * Time: 15:59
 */

namespace Users\Form;

use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain', true
                    )
                )
            )
        ));

        $this->add(array(
            $this->add(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 140
                        )
                    )
                )
            ))
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true
        ));

        $this->add(array(
            'name' => 'confirm_password',
            'required' => true
        ));
    }
}