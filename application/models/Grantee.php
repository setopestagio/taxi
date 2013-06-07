<?php

class Application_Model_Grantee
{

	public function newGrantee($data)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$newGrantee = $grantee->createRow();
		$address = new Application_Model_Address();
		$person = new Application_Model_Person();
		$vehicle = new Application_Model_Vehicle();
		$addressId = $address->newAddress($data);
		$personId = $person->newPerson($data, $addressId);
		$vehicleId = $vehicle->newVehicle($data);
		$newGrantee->permission = $data['permission'];
		$newGrantee->owner = $personId;
		$newGrantee->authorization = $data['authorization'];
		$newGrantee->city = $data['city'];
		$newGrantee->vehicle = $vehicleId;
		$newGrantee->start_permission = Application_Model_General::dateToUs($data['start_permission']);
		return $newGrantee->save();
	}

	public function lists()
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission') )

						->joinInner(array('p' => 'person'), 'p.id=g.owner');
		return $grantee->fetchAll($select);
	}

	public function returnById($granteeId)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission') )
						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																																			'address_city' => 'city','zipcode') )
						->joinInner(array('v' => 'vehicle'), 'v.id=g.vehicle')
						->where('g.id = ?', $granteeId);
						echo $select;
		return $grantee->fetchRow($select);
	}

	public function editGrantee($data, $granteeId)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$editGrantee = $grantee->fetchRow($grantee->select()->where('id = ?',$granteeId));
		$editGrantee->id = $granteeId;
		$person = new Application_Model_Person();
		$vehicle = new Application_Model_Vehicle();
		$person->editPerson($data,$editGrantee->owner);
		$vehicle->editVehicle($data,$editGrantee->vehicle);
		$editGrantee->permission = $data['permission'];
		$editGrantee->authorization = $data['authorization'];
		$editGrantee->city = $data['city'];
		$editGrantee->start_permission = Application_Model_General::dateToUs($data['start_permission']);
		if($editGrantee->save())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function findByPermission($permission)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission') )

						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->where('g.permission = ?',$permission);
		return $grantee->fetchRow($select);
	}

}

