<?php

class Application_Model_User
{

	public function newUser($data)
	{
		if($data['password'] == $data['confirm_password'] && strlen($data['password']) > 4 && strlen($data['username']) > 4 )
		{
			$user = new Application_Model_DbTable_User();
			$userRow = $user->createRow();
			$userRow->name = $data['name'];
			$userRow->username = $data['username'];
			$userRow->password = sha1($data['password']);
			$userRow->email = $data['email'];
			$userRow->phone = $data['phone'];
			$userRow->date = new Zend_Db_Expr('NOW()');
			$userRow->institution = 1;
			return $userRow->save();
		}
    return false;
	}

	public function lists()
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchAll($user->select()->where('institution = 1'));
	}

	public function editUser($data,$userId)
	{
		$user = new Application_Model_DbTable_User();
		$userRow = $user->fetchRow($user->select()->where('id = ?',$userId));
		if($userRow)
		{
			$userRow->name = $data['name'];
			$userRow->email = $data['email'];
			$userRow->phone = $data['phone'];
			return $userRow->save();
		}
		return false;
	}

	public function returnById($userId)
	{
		$user = new Application_Model_DbTable_User();
		$select = $user->select()->setIntegrityCheck(false);
		$select	->from(array('u' => 'user'));
		return $user->fetchRow($user->select()->where('id = ?',$userId)->where('institution = 1'));
	}

	public function findByMASP($masp)
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchAll($user->select()->where('masp = ?',$masp)->where('institution = 1'));
	}

	public function findByName($name)
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchAll($user->select()->where('name LIKE ?', '%'.$name.'%')->where('institution = 1'));
	}

}

