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

class UploadManagerController extends AbstractActionController
{
    public function indexAction()
    {
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $userTable = $this->getServiceLocator()->get('UserTable');

        //Get user info from session
        $authService = $this->getServiceLocator()->get('GetAuthService');
        $userEmail = $authService->getStorage()->read();

        $user = $userTable->getUserByEmail($userEmail);

        $viewModel = new ViewModel(array(
            'myUploads' => $uploadTable->getUploadsByUserId($user->id)
        ));
        return $viewModel;
    }

    public function uploadAction()
    {
        $form = $this->getServiceLocator()->get('UploadForm');
        $viewModel = new ViewModel(array(
            'form' => $form
        ));
        return $viewModel;
    }

    public function getFileUploadLocation()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['module_config']['upload_location'];
    }

    public function processAction()
    {
        $uploadFile = $this->params()->fromFiles('fileupload');
        $form = $this->getServiceLocator()->get('UploadForm');
        $form->setData($this->request->getPost());

        if ($form->isValid()) {
            //Fetch Configuration from Module Config
            $uploadPath = $this->getFileUploadLocation();

            //Save Uploaded File
            $adapter = new \Zend\File\Transfer\Adapter\Http();
            $adapter->setDestination($uploadPath);
            if ($adapter->receive($uploadFile['name'])) {
                //Get tables to retrieve data and save upload
                $uploadTable = $this->getServiceLocator()->get('UploadTable');
                $userTable = $this->getServiceLocator()->get('UserTable');

                //Get user info from session
                $authService = $this->getServiceLocator()->get('GetAuthService');
                $userEmail = $authService->getStorage()->read();

                $user = $userTable->getUserByEmail($userEmail);
                $upload = $this->getServiceLocator()->get('Upload');

                //File upload successful
                $exchange_data = array();
                $exchange_data['label'] = $this->request->getPost()->get('description');
                $exchange_data['filename'] = $uploadFile['name'];
                $exchange_data['user_id'] = $user->id;

                $upload->exchangeArray($exchange_data);
                $uploadTable->saveUpload($upload);

                return $this->redirect()->toRoute(null, array(
                    'controller' => 'upload-manager',
                    'action' => 'index'
                ));
            }
        }

    }

    public function deleteAction()
    {
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $upload = $uploadTable->getUpload($this->params()->fromRoute('id'));

        unlink($this->getFileUploadLocation() . '/' . $upload->filename);
        $uploadTable->deleteUpload($this->params()->fromRoute('id'));

        $this->redirect()->toRoute(null, array(
            'controller' => 'upload-manager',
            'action' => 'index'
        ));
    }
}