<?php

class Application_Model_Auxiliar
{
	public function newAuxiliar($data)
	{
		$address = new Application_Model_Address();
		$person = new Application_Model_Person();
		$addressId = $address->newAddress($data);
		return $person->newPerson($data, $addressId);
	}

	public function saveToGrantee($permission,$startDate,$auxiliarId)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$granteeRow = $grantee->fetchRow($grantee->select()->where('permission = ?',$permission));
		if($granteeRow)
		{
			$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
			$granteeAuxiliarRow = $granteeAuxiliar->createRow();
			$granteeAuxiliarRow->grantee = $granteeRow->id;
			$granteeAuxiliarRow->auxiliar = $auxiliarId;
			$granteeAuxiliarRow->start_date = Application_Model_General::dateToUs($startDate);
			$granteeAuxiliarRow->save();
		}
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
		$select	->from(array('p' => 'person'),array('id_auxiliar' => 'id','name','phone','mobile','email','rg','rg_issuer','cpf','cnh',
																										'cnh_issuer', 'iapas', 'voter', 'voter_zone', 'army', 'army_issuer','info') )
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																																			'address_city' => 'city','zipcode') )
						->joinInner(array('c' => 'city'),'a.city=c.id', array('name_city' => 'name'))
						->joinLeft(array('aux' => 'grantee_auxiliar'),'aux.auxiliar=p.id AND aux.end_date IS NULL',array('start_permission' => 'start_date'))
						->joinLeft(array('g' => 'grantee'),'g.id=aux.grantee',array('permission', 'pendencies')) 
						->joinleft(array('pg' => 'person'),'g.owner=pg.id',array('name_grantee' => 'name'))
						->joinLeft(array('v' => 'vehicle'),'v.id=g.vehicle')
						->joinLeft(array('vb' => 'vehicle_brand'), 'vb.id=v.brand', array('vehicle_brand' => 'name'))
						->joinLeft(array('f' => 'vehicle_fuel'), 'f.id=v.fuel', array('vehicle_fuel' => 'name'))
						->joinLeft(array('tb' => 'taximeter_brand'), 'tb.id=v.taximeter_brand', array('taximeter_brand' => 'name','taximeter_brand_id' => 'id'))
						->joinLeft(array('tm' => 'taximeter_model'), 'tm.id=v.taximeter_model', array('taximeter_model' => 'name', 'taximeter_model_id' => 'id'))
						->joinLeft(array('vm' => 'vehicle_model'), 'vm.id=v.model', array('vehicle_model' => 'name'))
						->where('p.id = ?', $id)
						->order('aux.start_date DESC');
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
						->where('p.name LIKE ?','%'.$name.'%');
		return $person->fetchAll($select);
	}
}

