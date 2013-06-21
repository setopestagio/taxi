<?php

class Application_Model_Auxiliar
{

	public function saveToGrantee($granteeId,$aux1='',$aux2='')
	{
		
	}

	public function lists()
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from( array('p' => 'person') )
						->where('p.id NOT IN (SELECT id FROM grantee WHERE end_permission IS NOT NULL)');
		return $person->fetchAll($select);
	}

	public function returnById($id)
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person') )
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																																			'address_city' => 'city','zipcode') )
						->joinInner(array('c' => 'city'),'a.city=c.id', array('name_city' => 'name'))
						->joinLeft(array('aux' => 'grantee_auxiliar'),'aux.auxiliar=p.id',array('start_permission' => 'start_date'))
						->joinLeft(array('g' => 'grantee'),'g.id=aux.grantee') 
						->joinLeft(array('v' => 'vehicle'),'v.id=g.vehicle')
						->where('p.id = ?', $id);
		return $person->fetchRow($select);
	}

	public function editAuxiliar($data,$id)
	{
		$person = new Application_Model_Person();
		if($person->editPerson($data,$id))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function findByCPF($cpf)
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person') )
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																																			'address_city' => 'city','zipcode') )
						->joinInner(array('c' => 'city'),'a.city=c.id', array('name_city' => 'name'))
						->where('p.cpf = ?',$cpf);
		return $person->fetchAll($select);
	}

	public function findByName($name)
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person') )
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																																			'address_city' => 'city','zipcode') )
						->joinInner(array('c' => 'city'),'a.city=c.id', array('name_city' => 'name'))
						->where('p.name LIKE ?','%'.utf8_encode($name).'%');
		return $person->fetchAll($select);
	}
}

