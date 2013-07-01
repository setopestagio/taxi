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
																								'start_permission','end_permission', 'info', 'pendencies') )
						->joinInner(array('p' => 'person'), 'p.id=g.owner')
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
						->where('a.grantee = ?',$granteeId)
						->where('a.end_date IS NULL');
		return $granteeAuxiliar->fetchAll($select);
	}

	public function returnAuxiliarsInactives($granteeId)
	{
		$granteeAuxiliar = new Application_Model_DbTable_GranteeAuxiliar();
		$select = $granteeAuxiliar->select()->setIntegrityCheck(false);
		$select	->from(array('a' => 'grantee_auxiliar'), array('_id' => 'id', 'start_date','end_date') )
						->joinInner(array('p' => 'person'), 'p.id=a.auxiliar')
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

	// METODO PROVISORIO SALVANDO 5 AUXILIARES PARA FINS DE CADASTRO
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
			if(isset($data['aux3_id']) && $data['aux3_id'] != '')
			{
				$granteeAuxiliarNew3 = $granteeAuxiliar->createRow();
				$granteeAuxiliarNew3->grantee = $granteeId;
				$granteeAuxiliarNew3->auxiliar = $data['aux3_id'];
				$granteeAuxiliarNew3->start_date = Application_Model_General::dateToUs($data['date_aux3']);
				if($data['date_end_aux3'] != '')
				{
					$granteeAuxiliarNew3->end_date = Application_Model_General::dateToUs($data['date_end_aux3']);
				}
				else
				{
					$granteeAuxiliarNew3->end_date = new Zend_Db_Expr('NULL');
				}
				$granteeAuxiliarNew3->save();
			}
			if(isset($data['aux4_id']) && $data['aux4_id'] != '')
			{
				$granteeAuxiliarNew4 = $granteeAuxiliar->createRow();
				$granteeAuxiliarNew4->grantee = $granteeId;
				$granteeAuxiliarNew4->auxiliar = $data['aux4_id'];
				$granteeAuxiliarNew4->start_date = Application_Model_General::dateToUs($data['date_aux4']);
				if($data['date_end_aux4'] != '')
				{
					$granteeAuxiliarNew4->end_date = Application_Model_General::dateToUs($data['date_end_aux4']);
				}
				else
				{
					$granteeAuxiliarNew4->end_date = new Zend_Db_Expr('NULL');
				}
				$granteeAuxiliarNew4->save();
			}
			if(isset($data['aux5_id']) && $data['aux5_id'] != '')
			{
				$granteeAuxiliarNew5 = $granteeAuxiliar->createRow();
				$granteeAuxiliarNew5->grantee = $granteeId;
				$granteeAuxiliarNew5->auxiliar = $data['aux5_id'];
				$granteeAuxiliarNew5->start_date = Application_Model_General::dateToUs($data['date_aux5']);
				if($data['date_end_aux5'] != '')
				{
					$granteeAuxiliarNew5->end_date = Application_Model_General::dateToUs($data['date_end_aux5']);
				}
				else
				{
					$granteeAuxiliarNew5->end_date = new Zend_Db_Expr('NULL');
				}
				$granteeAuxiliarNew5->save();
			}
			return true;
		}catch(Zend_Exception $e){
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
						->where('p.name LIKE ?','%'.utf8_encode($name).'%');
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

	public function saveReservation($data,$granteeId)
	{
		$granteeReservation = new Application_Model_DbTable_GranteeReservation();
		if($data['end_date_reservation'])
		{
			$granteeReservationRow = $granteeReservation->fetchRow($granteeReservation->select()
																												->where('grantee = ?',$granteeId)
																												->where('end_date IS NULL'));
			$granteeReservationRow->grantee = $granteeId;
			$granteeReservationRow->start_date = Application_Model_General::dateToUs($data['start_date_reservation']);
			$granteeReservationRow->end_date = Application_Model_General::dateToUs($data['end_date_reservation']);
			$granteeReservationRow->reason = $data['reason'];
			$granteeReservationRow->info = $data['info'];
		}
		else
		{
			$granteeReservationRow = $granteeReservation->createRow();
			$granteeReservationRow->grantee = $granteeId;
			$granteeReservationRow->start_date = Application_Model_General::dateToUs($data['start_date_reservation']);
			$granteeReservationRow->reason = $data['reason'];
			$granteeReservationRow->info = $data['info'];
		}
		return $granteeReservationRow->save();
	}

	public function returnReservation($granteeId)
	{
		$granteeReservation = new Application_Model_DbTable_GranteeReservation();
		$granteeReservationRow = $granteeReservation->fetchRow($granteeReservation->select()
																									->where('grantee = ?',$granteeId)
																									->where('end_date IS NULL'));
		if($granteeReservationRow)
		{
			return $granteeReservationRow;
		}
		return 0;
	}

	public function returnReservationHistoric($granteeId)
	{
		$granteeReservation = new Application_Model_DbTable_GranteeReservation();
		$granteeReservationRow = $granteeReservation->fetchAll($granteeReservation->select()
																									->where('grantee = ?',$granteeId)
																									->where('end_date IS NOT NULL'));
		return $granteeReservationRow;
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

}

