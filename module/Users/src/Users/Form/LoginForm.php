<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 23/12/2014
 * Time: 14:54
 */

namespace Users\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('Login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'email',
            'attributes', array(
                'type' => 'email',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Email'
            ),
            'filters' => array(
                'name' => 'StringTrim'
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address format is invalid'
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Password'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login'
            ),
            'options' => array(
                'label' => 'Login'
            )
        ));
    }
}