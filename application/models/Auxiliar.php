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

	public function saveToGrantee($granteeId,$startDate,$auxiliarId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$granteeAuxiliarRow = $granteeAuxiliar->createRow();
		$granteeAuxiliarRow->grantee = $granteeId;
		$granteeAuxiliarRow->auxiliar = $auxiliarId;
		$granteeAuxiliarRow->start_date = Application_Model_General::dateToUs($startDate);
		$granteeAuxiliarRow->save();
	}

	public function lists()
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from( array('p' => 'person') )
						->order('name');
		return $person->fetchAll($select);
	}

	public function findAll()
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person'),array('id_auxiliar' => 'id','name','rg_completo' => 'CONCAT(p.rg," ",p.rg_issuer)','p.cpf'))
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address_complete' => 'CONCAT(a.address," ",a.number," ",a.apartament)',
																																			'neighborhood','address_city' => 'city','zipcode') )
						->joinLeft(array('c' => 'city'),'a.city=c.id', array('city_address' => 'name'))
						->joinLeft(array('aux' => 'grantee_auxiliar'),'aux.auxiliar=p.id',array('start_permission' => 'start_date', 'end_permission' => 'end_date'))
						->joinLeft(array('g' => 'grantee'),'g.id=aux.grantee',array('grantee_permission' => 'permission', 'pendencies')) 
						->joinleft(array('pg' => 'person'),'g.owner=pg.id',array('name_grantee' => 'name'))
						->joinLeft(array('cd' => 'city'),'g.city=cd.id', array('grantee_city' => 'name'))
						->order('p.name');
		return $person->fetchAll($select);	
	}

	public function findAllCity($city) // recebe a cidade
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person'),array('id_auxiliar' => 'id','name','rg_completo' => 'CONCAT(p.rg," ",p.rg_issuer)','p.cpf'))
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address_complete' => 'CONCAT(a.address," ",a.number," ",a.apartament)',
																																			'neighborhood','address_city' => 'city','zipcode') )
						->joinLeft(array('c' => 'city'),'a.city=c.id', array('city_address' => 'name'))
						->joinLeft(array('aux' => 'grantee_auxiliar'),'aux.auxiliar=p.id',array('start_permission' => 'start_date', 'end_permission' => 'end_date'))
						->joinLeft(array('g' => 'grantee'),'g.id=aux.grantee',array('grantee_permission' => 'permission', 'pendencies')) 
						->joinleft(array('pg' => 'person'),'g.owner=pg.id',array('name_grantee' => 'name'))
						->joinLeft(array('cd' => 'city'),'g.city=cd.id', array('grantee_city' => 'name'))
						->where('cd.id = ?', $city)
						->order('p.name');
		return $person->fetchAll($select);	
	}

	public function findAllActive()
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person'),array('id_auxiliar' => 'id','name','rg_completo' => 'CONCAT(p.rg," ",p.rg_issuer)','p.cpf'))
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address_complete' => 'CONCAT(a.address," ",a.number," ",a.apartament)',
																																			'neighborhood','address_city' => 'city','zipcode') )
						->joinLeft(array('c' => 'city'),'a.city=c.id', array('city_address' => 'name'))
						->joinLeft(array('aux' => 'grantee_auxiliar'),'aux.auxiliar=p.id',array('start_permission' => 'start_date', 'end_permission' => 'end_date'))
						->joinLeft(array('g' => 'grantee'),'g.id=aux.grantee',array('grantee_permission' => 'permission', 'pendencies')) 
						->joinleft(array('pg' => 'person'),'g.owner=pg.id',array('name_grantee' => 'name'))
						->joinLeft(array('cd' => 'city'),'g.city=cd.id', array('grantee_city' => 'name'))
						->where('aux.end_date IS NULL')
						->order('p.name');
		return $person->fetchAll($select);	
	}

	public function findAllActiveCity($city) // recebe a cidade
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person'),array('id_auxiliar' => 'id','name','rg_completo' => 'CONCAT(p.rg," ",p.rg_issuer)','p.cpf'))
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address_complete' => 'CONCAT(a.address," ",a.number," ",a.apartament)',
																																			'neighborhood','address_city' => 'city','zipcode') )
						->joinLeft(array('c' => 'city'),'a.city=c.id', array('city_address' => 'name'))
						->joinLeft(array('aux' => 'grantee_auxiliar'),'aux.auxiliar=p.id',array('start_permission' => 'start_date', 'end_permission' => 'end_date'))
						->joinLeft(array('g' => 'grantee'),'g.id=aux.grantee',array('grantee_permission' => 'permission', 'pendencies')) 
						->joinleft(array('pg' => 'person'),'g.owner=pg.id',array('name_grantee' => 'name'))
						->joinLeft(array('cd' => 'city'),'g.city=cd.id', array('grantee_city' => 'name'))
						->where('cd.id = ?', $city)
						->where('aux.end_date IS NULL')
						->order('p.name');
		return $person->fetchAll($select);	
	}
	
	public function findGranteeAuxiliarActive($date) // recebe o periodo de corte
	{
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		$grantee_auxiliar = $db->query("
			SELECT count(DISTINCT(p.name)) as num_aux,
			(
    		SELECT count(DISTINCT(p.name)) as num_grantee
			FROM `person` as p
			INNER JOIN grantee as g ON g.owner = p.id
			WHERE g.end_permission <='".Application_Model_General::dateToUs($date)."') as num_grantee,
			('".$date."') as data_pesquisa
			FROM `person` as p
			INNER JOIN grantee_auxiliar as aux ON aux.auxiliar = p.id
			INNER JOIN grantee as g ON g.owner = aux.grantee
			WHERE aux.end_date <='".Application_Model_General::dateToUs($date)."'");
		return $grantee_auxiliar->fetchAll();
	}

	public function findGranteeAuxiliarActiveCity($date, $city) // recebe a cidade e o periodo de corte
	{
	
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		$grantee_auxiliar = $db->query("
		SELECT count(DISTINCT(p.name)) as num_aux,
		(
    		SELECT count(DISTINCT(p.name)) as num_grantee
			FROM `person` as p
			INNER JOIN grantee as g ON g.owner = p.id
    		INNER JOIN city as c ON c.id = g.city
			WHERE c.id =".$city." AND g.end_permission <=".Application_Model_General::dateToUs($date).") as num_grantee,
			('".$date."') as data_pesquisa
		FROM `person` as p
		INNER JOIN grantee_auxiliar as ga ON ga.auxiliar = p.id
		INNER JOIN grantee as g ON g.owner = ga.grantee
		INNER JOIN city as c ON c.id = g.city
		WHERE c.id =".$city." AND ga.end_date <='".Application_Model_General::dateToUs($date)."'");
		return $grantee_auxiliar->fetchAll();
	}
	public function returnById($id)
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person'),array('id_auxiliar' => 'id','name','phone','mobile','email','rg','rg_issuer','cpf','cnh',
																	'cnh_issuer', 'iapas', 'voter', 'voter_zone', 'army', 'army_issuer','info', 'info_auxiliar') )
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																	'address_city' => 'city','zipcode') )
						->joinLeft(array('c' => 'city'),'a.city=c.id', array('name_city' => 'name'))
						->joinLeft(array('aux' => 'grantee_auxiliar'),'aux.auxiliar=p.id AND aux.end_date IS NULL',array('start_permission' => 'start_date', 'end_permission' => 'end_date'))
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
						->joinLeft(array('c' => 'city'),'a.city=c.id', array('name_city' => 'name'))
						->where('p.cpf = ?',$cpf)
						->order('name');
		return $person->fetchAll($select);
	}

	public function findByName($name)
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person') )
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
															'address_city' => 'city','zipcode') )
						->joinLeft(array('c' => 'city'),'a.city=c.id', array('name_city' => 'name'))
						->where('p.name LIKE ?','%'.$name.'%')
						->order('name');
		return $person->fetchAll($select);
	}

	public function returnGrantees($auxiliarId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$select = $granteeAuxiliar->select()->setIntegrityCheck(false);
		$select ->from(array('ga' => 'grantee_auxiliar'), array('_id' => 'id', 'grantee', 'auxiliar', 'start_date', 'end_date', 
															'nameGrantee' => 'name', 'permissionGrantee' => 'permission') )
				->joinLeft(array('g' => 'grantee'),'g.id=ga.grantee',array('permission'))
				->joinLeft(array('p' => 'person'), 'g.owner=p.id',array('name'))
				->where('ga.auxiliar = ?',$auxiliarId)
				->order('ga.end_date');
		return $granteeAuxiliar->fetchAll($select);
	}

	public function saveGranteesToAuxiliar($data,$auxiliarId)
	{
		try{
			$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
			if( isset($data['grantee_new_id']) && $data['grantee_new_id'] != '' )
			{
				$granteeAuxiliarNew = $granteeAuxiliar->createRow();
				$granteeAuxiliarNew->grantee = $data['grantee_new_id'];
				$granteeAuxiliarNew->auxiliar = $data['aux_id'];
				$granteeAuxiliarNew->start_date = Application_Model_General::dateToUs($data['start_date_new_grantee']);
				$granteeAuxiliarNew->end_date = Application_Model_General::dateToUs($data['end_date_new_grantee']);
				return $granteeAuxiliarNew->save();
			}
			else
			{
				if($data['existsGrantee'] == 2)
				{
					$granteeAuxiliarNew = $granteeAuxiliar->createRow();
					$granteeAuxiliarNew->auxiliar = $auxiliarId;
					$granteeAuxiliarNew->start_date = Application_Model_General::dateToUs($data['start_date_new_grantee']);
					$granteeAuxiliarNew->end_date = Application_Model_General::dateToUs($data['end_date_new_grantee']);
					$granteeAuxiliarNew->name = $data['grantee_name'];
					$granteeAuxiliarNew->permission = $data['grantee_permission'];
					return $granteeAuxiliarNew->save();
				}
				else
				{
					$granteeAuxiliarRow = $granteeAuxiliar->fetchRow($granteeAuxiliar->select()->where('id = ?',$data['id']));
					$granteeAuxiliarRow->start_date = Application_Model_General::dateToUs($data['start_date_aux']);
					$granteeAuxiliarRow->end_date = Application_Model_General::dateToUs($data['end_date_aux']);
					return $granteeAuxiliarRow->save();
				}
			}
		}catch(Zend_Exception $e){
			return false;
		}
	}

	public function removeGranteesToAuxiliar($data,$auxiliarId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$granteeAuxiliarRow = $granteeAuxiliar->fetchRow($granteeAuxiliar->select()->where('id = ?',$data['id'])
																	->where('auxiliar = ?',$auxiliarId));
		return $granteeAuxiliarRow->delete();
	}

	public function remove($auxiliarId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$granteeAuxiliarRow = $granteeAuxiliar->fetchAll($granteeAuxiliar->select()->where('auxiliar = ?',$auxiliarId));
		foreach($granteeAuxiliarRow as $granteeAuxiliarAux)
		{
			$granteeAuxiliarAux->delete();
		}
		$person = new Application_Model_DbTable_Person();
		$auxiliarRow = $person->fetchRow($person->select()->where('id = ?', $auxiliarId));
		return $auxiliarRow->delete();
	}

	public function findGranteeByName($name)
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person') )
						->joinInner(array('g' => 'grantee'), 'p.id=g.owner' ,array('id', 'name' => 'CONCAT(p.name," - ",g.permission)') )
						->where('p.name LIKE ?','%'.$name.'%');
		$people = $person->fetchAll($select);
		$aux = array();
		foreach($people as $person)
		{
			$flag = array('id' => $person->id, 'label' => Application_Model_General::removeAccents($person->name));
			array_push($aux,$flag);
		}
		return $aux;
	}
}

