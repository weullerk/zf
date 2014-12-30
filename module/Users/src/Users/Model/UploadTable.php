<?php
/**
 * Created by PhpStorm.
 * User: weuller.krysthian
 * Date: 24/12/2014
 * Time: 09:56
 */

namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UploadTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveUpload(Upload $upload)
    {
        $data = array(
            'filename' => $upload->filename,
            'label' => $upload->label,
            'user_id' => $upload->user_id
        );

        $id = (int) $upload->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUpload($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Upload ID does not exist');
            }
        }
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUpload($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getUploadsByUserId($userId)
    {
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(array('user_id' => $userId));

        if (!$rowset) {
            throw new \Exception("Could not find row $userId");
        }
        return $rowset;
     }

    public function deleteUpload($id)
    {
        $id = (int) $id;
        $this->tableGateway->delete(array('id' => $id));
    }
}