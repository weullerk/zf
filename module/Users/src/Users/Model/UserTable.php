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

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveUser(User $user)
    {
        $data = array(
            'email' => $user->email,
            'name' => $user->name,
            'password' => $user->password
        );

        $id = (int) $user->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('User ID does not exist');
            }
        }
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getUserByEmail($userEmail)
    {
        $rowset = $this->tableGateway->select(array('email' => $userEmail));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $userEmail");
        }
        return $row;
     }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function getAllUsersForSelect() {
        $users = array();

        $rowset = $this->tableGateway->select(
            function(\Zend\Db\Sql\Select $select) {
                $select->columns(array('id', 'name'));
            }
        );

        foreach($rowset as $user) {
            $users[$user->id] = $user->name;
        }

        return $users;
    }
}