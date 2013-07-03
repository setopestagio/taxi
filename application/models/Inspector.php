<?php

class Application_Model_Inspector
{

	public function newInspector($data)
	{
		if($data['password'] == $data['confirm_password'] && strlen($data['password']) > 4 && strlen($data['username']) > 4 )
		{
			$inspector = new Application_Model_DbTable_User();
			$inspectorRow = $inspector->createRow();
			$inspectorRow->name = $data['name'];
			$inspectorRow->username = $data['username'];
			$inspectorRow->password = sha1($data['password']);
			$inspectorRow->email = $data['email'];
			$inspectorRow->phone = $data['phone'];
			$inspectorRow->date = new Zend_Db_Expr('NOW()');
			$inspectorRow->institution = 2;
			$inspectorRow->masp = $data['masp'];
			$inspectorRow->cpf = $data['cpf'];
			return $inspectorRow->save();
		}
    return false;
	}

	public function lists()
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchAll($user->select()->where('institution = 2'));
	}

	public function editUser($data,$userId)
	{
		$inspector = new Application_Model_DbTable_User();
		$inspectorRow = $inspector->fetchRow($inspector->select()->where('id = ?',$userId));
		if($inspectorRow)
		{
			$inspectorRow->name = $data['name'];
			$inspectorRow->email = $data['email'];
			$inspectorRow->phone = $data['phone'];
			$inspectorRow->masp = $data['masp'];
			$inspectorRow->cpf = $data['cpf'];
			return $inspectorRow->save();
		}
		return false;
	}

	public function returnById($userId)
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchRow($user->select()->where('id = ?',$userId)->where('institution = 2'));
	}

	public function findByMASP($masp)
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchAll($user->select()->where('masp = ?',$masp)->where('institution = 2'));
	}

	public function findByCPF($cpf)
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchAll($user->select()->where('cpf = ?',$cpf)->where('institution = 2'));
	}

	public function findByName($name)
	{
		$user = new Application_Model_DbTable_User();
		return $user->fetchAll($user->select()->where('name LIKE ?', '%'.$name.'%')->where('institution = 2'));
	}

}

