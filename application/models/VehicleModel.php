<?php

class Application_Model_VehicleModel
{

	public function newModelVehicle($data)
	{
		$vehicleModel = new Application_Model_DbTable_VehicleModel();
		$vehicleModelRow = $vehicleModel->createRow();
		$vehicleModelRow->name = $data['name'];
		return $vehicleModelRow->save();
	}

	public function lists()
	{
		$vehicleModel = new Application_Model_DbTable_VehicleModel();
		return $vehicleModel->fetchAll();
	}

	public function editModelVehicle($data,$vehicleModelId)
	{
		$vehicleModel = new Application_Model_DbTable_VehicleModel();
		$vehicleModelRow = $vehicleModel->fetchRow($vehicleModel->select()->where('id = ?',$vehicleModelId));
		if($vehicleModelRow)
		{
			$vehicleModelRow->name = $data['name'];
			return $vehicleModelRow->save();
		}
		return false;
	}

	public function returnById($vehicleModelId)
	{
		$vehicleModel = new Application_Model_DbTable_VehicleModel();
		$select = $vehicleModel->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'vehicle_model'));
		return $vehicleModel->fetchRow($vehicleModel->select()->where('id = ?',$vehicleModelId));
	}

	public function findByName($name)
	{
		$vehicleModel = new Application_Model_DbTable_VehicleModel();
		return $vehicleModel->fetchAll($vehicleModel->select()->where('name LIKE ?', '%'.$name.'%'));
	}

}

