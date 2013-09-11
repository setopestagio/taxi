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
		$newGrantee->end_permission = Application_Model_General::dateToUs($data['end_permission']);
		$newGrantee->info = $data['info'];
		$newGrantee->pendencies = $data['pendencies'];
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
																					'start_permission','end_permission', 'info_grantee' => 'info', 'pendencies') )
						->joinInner(array('p' => 'person'), 'p.id=g.owner', array('permission', 'name', 'name_grantee' => 'name', 'address',
																					'phone', 'mobile', 'email', 'rg', 'rg_issuer', 'cpf',
																					'cnh', 'cnh_issuer', 'iapas', 'voter', 'voter_zone', 'army',
																					'army_issuer', 'info'))
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																					'address_city' => 'city','zipcode') )
						->joinInner(array('v' => 'vehicle'), 'v.id=g.vehicle')
						->joinInner(array('c' => 'city'),'g.city=c.id', array('name_city' => 'name'))
						->joinInner(array('vb' => 'vehicle_brand'), 'vb.id=v.brand', array('vehicle_brand' => 'name'))
						->joinInner(array('f' => 'vehicle_fuel'), 'f.id=v.fuel', array('vehicle_fuel' => 'name'))
						->joinInner(array('tb' => 'taximeter_brand'), 'tb.id=v.taximeter_brand', array('taximeter_brand' => 'name','taximeter_brand_id' => 'id'))
						->joinInner(array('tm' => 'taximeter_model'), 'tm.id=v.taximeter_model', array('taximeter_model' => 'name', 'taximeter_model_id' => 'id'))
						->joinInner(array('vm' => 'vehicle_model'), 'vm.id=v.model', array('vehicle_model' => 'name'))
						->where('g.id = ?', $granteeId);
		return $grantee->fetchRow($select);
	}

	public function returnAuxiliars($granteeId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$select = $granteeAuxiliar->select()->setIntegrityCheck(false);
		$select	->from(array('a' => 'grantee_auxiliar') )
						->joinInner(array('p' => 'person'), 'p.id=a.auxiliar')
						->joinLeft(array('g' => 'grantee'), 'g.id=a.auxiliar')
						->where('a.grantee = ?',$granteeId)
						->where('a.end_date IS NULL')
						->where('g.id IS NULL');
		return $granteeAuxiliar->fetchAll($select);
	}

	public function returnAuxiliarsInactives($granteeId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$select = $granteeAuxiliar->select()->setIntegrityCheck(false);
		$select	->from(array('a' => 'grantee_auxiliar'), array('_id' => 'id', 'start_date','end_date') )
						->joinInner(array('p' => 'person'), 'p.id=a.auxiliar')
						->order('a.start_date ASC')
						->where('a.grantee = ?',$granteeId)
						->where('a.end_date IS NOT NULL');
		return $granteeAuxiliar->fetchAll($select);
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
		if($data['end_permission'] != '')
			$editGrantee->end_permission = Application_Model_General::dateToUs($data['end_permission']);
		$editGrantee->info = $data['info'];
		$editGrantee->pendencies = $data['pendencies'];
		if($editGrantee->save())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function saveAuxiliars($data,$granteeId)
	{
		try{
			$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
			if( ( isset($data['aux1_id']) && $data['aux1_id'] != '' ) && !isset($data['exists_aux_1']) )
			{
				$granteeAuxiliarNew = $granteeAuxiliar->createRow();
				$granteeAuxiliarNew->grantee = $granteeId;
				$granteeAuxiliarNew->auxiliar = $data['aux1_id'];
				$granteeAuxiliarNew->start_date = Application_Model_General::dateToUs($data['date_aux1']);
				if($data['date_end_aux1'] != '')
				{
					$granteeAuxiliarNew->end_date = Application_Model_General::dateToUs($data['date_end_aux1']);
				}
				else
				{
					$granteeAuxiliarNew->end_date = new Zend_Db_Expr('NULL');
				}
				$granteeAuxiliarNew->save();
			}
			if( ( isset($data['aux2_id']) && $data['aux2_id'] != '' ) && !isset($data['exists_aux_2']) )
			{
				$granteeAuxiliarNew2 = $granteeAuxiliar->createRow();
				$granteeAuxiliarNew2->grantee = $granteeId;
				$granteeAuxiliarNew2->auxiliar = $data['aux2_id'];
				$granteeAuxiliarNew2->start_date = Application_Model_General::dateToUs($data['date_aux2']);
				if($data['date_end_aux2'] != '')
				{
					$granteeAuxiliarNew2->end_date = Application_Model_General::dateToUs($data['date_end_aux2']);
				}
				else
				{
					$granteeAuxiliarNew2->end_date = new Zend_Db_Expr('NULL');
				}
				$granteeAuxiliarNew2->save();
			}
			return true;
		}catch(Zend_Exception $e){
			return false;
		}
	}

	public function findActiveGrantee($permission)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission') )

						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->where('g.permission = ?',$permission)
						->where('g.end_permission = ?','0000-00-00');
		return $grantee->fetchAll($select);
	}

	public function findByPermission($permission)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission') )

						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->where('g.permission = ?',$permission);
		return $grantee->fetchAll($select);
	}

	public function findByCPF($cpf)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission') )

						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->where('p.cpf = ?',$cpf);
		return $grantee->fetchAll($select);
	}

	public function findByName($name)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission') )

						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->where('p.name LIKE ?','%'.$name.'%');
		return $grantee->fetchAll($select);
	}

	public function findAll()
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission', 'info', 'pendencies') )
						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																																			'address_city' => 'city','zipcode') )
						->joinInner(array('v' => 'vehicle'), 'v.id=g.vehicle')
						->joinInner(array('c' => 'city'),'g.city=c.id', array('name_city' => 'name'))
						->joinInner(array('vb' => 'vehicle_brand'), 'vb.id=v.brand', array('vehicle_brand' => 'name'))
						->joinInner(array('f' => 'vehicle_fuel'), 'f.id=v.fuel', array('vehicle_fuel' => 'name'))
						->joinInner(array('tb' => 'taximeter_brand'), 'tb.id=v.taximeter_brand', array('taximeter_brand' => 'name'))
						->joinInner(array('tm' => 'taximeter_model'), 'tm.id=v.taximeter_model', array('taximeter_model' => 'name'))
						->joinInner(array('vm' => 'vehicle_model'), 'vm.id=v.model', array('vehicle_model' => 'name'))
						->order('p.name');
		return $grantee->fetchAll($select);
	}

	public function findActives()
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'), array('grantee_id' => 'id', 'permission','authorization','city',
																								'start_permission','end_permission', 'info', 'pendencies') )
						->joinInner(array('p' => 'person'), 'p.id=g.owner')
						->joinInner(array('a' => 'address'),'a.id = p.address', array('address','number','apartament','neighborhood',
																																			'address_city' => 'city','zipcode') )
						->joinInner(array('v' => 'vehicle'), 'v.id=g.vehicle')
						->joinInner(array('c' => 'city'),'g.city=c.id', array('name_city' => 'name'))
						->joinInner(array('vb' => 'vehicle_brand'), 'vb.id=v.brand', array('vehicle_brand' => 'name'))
						->joinInner(array('f' => 'vehicle_fuel'), 'f.id=v.fuel', array('vehicle_fuel' => 'name'))
						->joinInner(array('tb' => 'taximeter_brand'), 'tb.id=v.taximeter_brand', array('taximeter_brand' => 'name'))
						->joinInner(array('tm' => 'taximeter_model'), 'tm.id=v.taximeter_model', array('taximeter_model' => 'name'))
						->joinInner(array('vm' => 'vehicle_model'), 'vm.id=v.model', array('vehicle_model' => 'name'))
						->where('g.end_permission = "0000-00-00"')
						->order('p.name');
		return $grantee->fetchAll($select);
	}

	public function findAuxByName($name)
	{
		$person = new Application_Model_DbTable_Person();
		$select = $person->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'person'), array('name','id') )
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

	public function returnPendencies($granteeId)
	{
		$grantee = new Application_Model_DbTable_Grantee();
		$granteeRow = $grantee->fetchRow($grantee->select()->where('id = ?',$granteeId));
		if($granteeRow->pendencies == '' || $granteeRow->pendencies == NULL)
		{
			return 'NADA CONSTA';
		}
		return $granteeRow->pendencies;
	}

	public function removeAuxiliar($granteeId,$auxiliarId,$endDate)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$granteeAuxiliarRow = $granteeAuxiliar->fetchRow($granteeAuxiliar->select()
																				->where('grantee = ?',$granteeId)
																				->where('auxiliar = ?',$auxiliarId));
		if($granteeAuxiliarRow)
		{
			$granteeAuxiliarRow->end_date = Application_Model_General::dateToUs($endDate);
			return $granteeAuxiliarRow->save();
		}
		return false;
	}

	public function saveReservation($data)
	{
		$granteeReservation = new Application_Model_DbTable_GranteeReservation();
		if(isset($data['id']) && $data['id'])
		{
			$granteeReservationRow = $granteeReservation->fetchRow($granteeReservation->select()
																												->where('id = ?',$data['id']));
			$granteeReservationRow->grantee = $data['grantee'];
			$granteeReservationRow->start_date = Application_Model_General::dateToUs($data['start_date']);
			$granteeReservationRow->end_date = Application_Model_General::dateToUs($data['end_date']);
			$granteeReservationRow->plate_date = Application_Model_General::dateToUs($data['plate_date']);
			$granteeReservationRow->period = $data['period'];
			$granteeReservationRow->reason = $data['reason'];
			$granteeReservationRow->info = $data['info'];
		}
		else
		{
			$granteeReservationRow = $granteeReservation->createRow();
			$granteeReservationRow->grantee = $data['grantee'];
			$granteeReservationRow->start_date = Application_Model_General::dateToUs($data['start_date']);
			$granteeReservationRow->end_date = Application_Model_General::dateToUs($data['end_date']);
			$granteeReservationRow->emission_date = new Zend_Db_Expr('NOW()');
			$granteeReservationRow->plate_date = Application_Model_General::dateToUs($data['plate_date']);
			$granteeReservationRow->period = $data['period'];
			$granteeReservationRow->reason = $data['reason'];
			$granteeReservationRow->info = $data['info'];
		}
		return $granteeReservationRow->save();
	}

	public function returnReservation($id)
	{
		$granteeReservation = new Application_Model_DbTable_GranteeReservation();
		$granteeReservationRow = $granteeReservation->fetchRow($granteeReservation->select()
																									->where('id = ?',$id));
		if($granteeReservationRow)
		{
			return $granteeReservationRow;
		}
		return 0;
	}

	public function returnReservationHistoric($granteeId)
	{
		$granteeReservation = new Application_Model_DbTable_GranteeReservation();
		$select = $granteeReservation->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee_reservation'), array('id', 'grantee', 
																								'start_date' => new Zend_Db_Expr ('DATE_FORMAT(start_date,"%d/%m/%Y")'),
																								'end_date' => new Zend_Db_Expr ('DATE_FORMAT(end_date,"%d/%m/%Y")'),
																								'plate_date' => new Zend_Db_Expr ('DATE_FORMAT(plate_date,"%d/%m/%Y")'),
																								'period', 'reason', 'info' ) )
						->order('start_date ASC')
						->where('grantee = ?',$granteeId);
		return $granteeReservation->fetchAll($select);
	}

	public function excludeAuxiliar($auxiliarGranteeId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$granteeAuxiliarRow = $granteeAuxiliar->fetchRow($granteeAuxiliar->select()->where('id = ?',$auxiliarGranteeId));
		if($granteeAuxiliarRow)
		{
			$granteeAuxiliarRow->delete();
			return true;
		}
		return false;
	}

	public function editAuxiliar($data)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$granteeAuxiliarRow = $granteeAuxiliar->fetchRow($granteeAuxiliar->select()->where('id = ?',$data['id']));
		if($granteeAuxiliarRow)
		{
			$granteeAuxiliarRow->start_date = Application_Model_General::dateToUs($data['start_date']);;
			$granteeAuxiliarRow->end_date = Application_Model_General::dateToUs($data['end_date']);;
			return $granteeAuxiliarRow->save();
		}
		return false;
	}

}

