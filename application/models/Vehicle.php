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
}

