<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 31/12/2014
 * Time: 08:48
 */

namespace Users\Form;

use Zend\Form\Form;

class UserSharingForm extends Form
{
    public function __construct($options = array())
    {
        parent::__construct('UserEdit');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'users',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required'
            ),
            'options' => array(
                'empty_option' => 'Select user',
                'value_options' => $options,
                'label' => 'Choose User:'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Add Share'
            ),
            'options' => array(
                'label' => 'Add Share'
            )
        ));
    }
}