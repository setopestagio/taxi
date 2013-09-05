<?php

class Application_Model_Vehicle
{

	public function newVehicle($data)
	{
		$vehicle = new Application_Model_DbTable_Vehicle();
		$newVehicle = $vehicle->createRow();
		$newVehicle->plate  = $data['plate'];
		$newVehicle->brand  = $data['brand'];
		$newVehicle->model  = $data['model'];
		$newVehicle->year_fabrication = $data['year_fabrication'];
		$newVehicle->year_model = $data['year_model'];
		$newVehicle->color = $data['color'];
		$newVehicle->chassi  = $data['chassi'];
		$newVehicle->fuel  = $data['fuel'];
		return $newVehicle->save();
	}

	public function editVehicle($data, $vehicleId)
	{
		$vehicle = new Application_Model_DbTable_Vehicle();
		$editVehicle = $vehicle->fetchRow($vehicle->select()->where('id = ?',$vehicleId));
		$editVehicle->id = $vehicleId;
		$editVehicle->plate  = $data['plate'];
		$editVehicle->brand  = $data['brand'];
		$editVehicle->model  = $data['model'];
		$editVehicle->year_fabrication = $data['year_fabrication'];
		$editVehicle->year_model = $data['year_model'];
		$editVehicle->color = $data['color'];
		$editVehicle->chassi  = $data['chassi'];
		$editVehicle->fuel  = $data['fuel'];
		return $editVehicle->save();
	}

	public function returnByPlate($plate)
	{
		$vehicle = new Application_Model_DbTable_Vehicle();
		return $vehicle->fetchRow($vehicle->select()->where('plate like ?',$plate));
	}

	public function returnAll()
	{
		$grantee = new Application_Model_DbTable_Vehicle();
		$select = $grantee->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'grantee'))
						->joinInner(array('v' => 'vehicle'), 'v.id=g.vehicle')
						->joinLeft(array('m' => 'vehicle_model'),'v.model=m.id',array('vehicle_model' => 'name'))
						->joinLeft(array('b' => 'vehicle_brand'),'v.brand=b.id',array('vehicle_brand' => 'name'))
						->joinLeft(array('f' => 'vehicle_fuel'),'v.fuel=f.id',array('vehicle_fuel' => 'name'))
						->where('g.end_permission IS NOT NULL')
						->where('g.info NOT LIKE "%transf%"')
						->where('g.end_permission="0000-00-00"')
						->where('v.plate IS NOT NULL')
						->where('v.plate!=""');
		return $grantee->fetchAll($select);
	}
}

