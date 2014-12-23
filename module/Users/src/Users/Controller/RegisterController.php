<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 23/12/2014
 * Time: 13:12
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\RegisterForm;
use Users\Form\RegisterFilter;

class RegisterController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new RegisterForm();
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }

    public function proccessAction()
    {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(null, array('controller' => 'register', 'action' => 'index'));
        }
        $post = $this->request->getPost();
        $form = new RegisterForm();
        $inputFilter = new RegisterFilter();
        $form->setInputFilter($inputFilter);
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form
            ));
            $model->setTemplate('users/register/index');
            return $model;
        }
        return $this->redirect()->toRoute(null, array(
            'controller' => 'register',
            'action' => 'confirm'
        ));
    }

    public function confirmAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }
}