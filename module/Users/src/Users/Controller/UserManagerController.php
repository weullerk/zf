<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 29/12/2014
 * Time: 13:19
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\User;
use Users\Model\UserTable;


class UserManagerController extends AbstractActionController
{
    public function indexAction()
    {
        $userTable = $this->getServiceLocator()->get('UserTable');
        $viewModel = new ViewModel(array('users' => $userTable->fetchAll()));
        return $viewModel;
    }

    public function editAction()
    {
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($this->params()->fromRoute('id'));
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $viewModel = new ViewModel(array(
            'form' => $form,
            'user_id' => $this->params()->fromRoute('id')
        ));
        return $viewModel;
    }

    public function processAction()
    {
        //Get User ID from POST
        $post = $this->request->getPost();
        $userTable = $this->getServiceLocator()->get('UserTable');

        //Load user entity to Form
        $user = $userTable->getUser($post->id);

        //Bind user entity to Form
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        $form->setData($post);

        if ($form->isValid()) {
            //Save user
            $this->getServiceLocator()->get('UserTable')->saveUser($user);
        }

        return $this->redirect()->toRoute(null, array(
            'controller' => 'user-manager',
            'action' => 'index'
        ));
    }

    public function deleteAction()
    {
        $this->getServiceLocator()->get('UserTable')->deleteUser($this->params()->fromRoute('id'));
        return $this->redirect()->toRoute(null, array(
            'controller' => 'user-manager',
            'action' => 'index'
        ));
    }

    public function createAction()
    {
        $form = $this->getServiceLocator()->get('RegisterForm');
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }

    public function processCreateAction()
    {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(null, array('controller' => 'user-manager', 'action' => 'index'));
        }

        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('RegisterForm');

        $form->setData($post);
        if ($form->isValid()) {
            $this->createUser($form->getData());
        }

        return $this->redirect()->toRoute(null, array(
            'controller' => 'user-manager',
            'action' => 'index'
        ));
    }

    public function createUser(array $data)
    {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \Users\Model\User);
        $tableGateway = new \Zend\Db\TableGateway\TableGateway('user', $dbAdapter, null, $resultSetPrototype);

        $user = new User();
        $user->exchangeArray($data);
        $userTable = new UserTable($tableGateway);
        $userTable->saveUser($user);
        return true;
    }
}