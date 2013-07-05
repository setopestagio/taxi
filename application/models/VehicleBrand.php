<?php

class Application_Model_VehicleBrand
{

	public function newBrandVehicle($data)
	{
		$vehicleBrand = new Application_Model_DbTable_VehicleBrand();
		$vehicleBrandRow = $vehicleBrand->createRow();
		$vehicleBrandRow->name = $data['name'];
		return $vehicleBrandRow->save();
	}

	public function lists()
	{
		$vehicleBrand = new Application_Model_DbTable_VehicleBrand();
		return $vehicleBrand->fetchAll();
	}

	public function editBrandVehicle($data,$vehicleBrandId)
	{
		$vehicleBrand = new Application_Model_DbTable_VehicleBrand();
		$vehicleBrandRow = $vehicleBrand->fetchRow($vehicleBrand->select()->where('id = ?',$vehicleBrandId));
		if($vehicleBrandRow)
		{
			$vehicleBrandRow->name = $data['name'];
			return $vehicleBrandRow->save();
		}
		return false;
	}

	public function returnById($vehicleBrandId)
	{
		$vehicleBrand = new Application_Model_DbTable_VehicleBrand();
		$select = $vehicleBrand->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'vehicle_brand'));
		return $vehicleBrand->fetchRow($vehicleBrand->select()->where('id = ?',$vehicleBrandId));
	}

	public function findByName($name)
	{
		$vehicleBrand = new Application_Model_DbTable_VehicleBrand();
		return $vehicleBrand->fetchAll($vehicleBrand->select()->where('name LIKE ?', '%'.$name.'%'));
	}

}

