<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 24/12/2014
 * Time: 09:01
 */

namespace Users\Form;

use Zend\InputFilter\InputFilter;

class UserEditFilter extends InputFilter
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
                        'domain' => true
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true
        ));
    }
}