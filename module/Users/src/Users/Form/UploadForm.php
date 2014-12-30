<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 30/12/2014
 * Time: 09:18
 */

namespace Users\Form;

use Zend\Form\Form;

class UploadForm extends Form
{
    public function __construct()
    {
        parent::__construct('Upload');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'fileupload',
            'attributes' => array(
                'type' => 'file'
            ),
            'options' => array(
                'label' => 'File Upload'
            )
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'File Description'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Upload Now'
            ),
            'options' => array(
                'label' => 'Upload Now'
            )
        ));
    }
}