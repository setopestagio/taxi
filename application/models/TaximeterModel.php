<?php

class Application_Model_TaximeterModel
{

	public function newModelTaximeter($data)
	{
		$modelTaximeter = new Application_Model_DbTable_TaximeterModel();
		$modelTaximeterRow = $modelTaximeter->createRow();
		$modelTaximeterRow->name = $data['name'];
		return $modelTaximeterRow->save();
	}

	public function lists()
	{
		$modelTaximeter = new Application_Model_DbTable_TaximeterModel();
		return $modelTaximeter->fetchAll();
	}

	public function editModelTaximeter($data,$modelTaximeterId)
	{
		$modelTaximeter = new Application_Model_DbTable_TaximeterModel();
		$modelTaximeterRow = $modelTaximeter->fetchRow($modelTaximeter->select()->where('id = ?',$modelTaximeterId));
		if($modelTaximeterRow)
		{
			$modelTaximeterRow->name = $data['name'];
			return $modelTaximeterRow->save();
		}
		return false;
	}

	public function returnById($modelTaximeterId)
	{
		$modelTaximeter = new Application_Model_DbTable_TaximeterModel();
		$select = $modelTaximeter->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'taximeter_model'));
		return $modelTaximeter->fetchRow($modelTaximeter->select()->where('id = ?',$modelTaximeterId));
	}

	public function findByName($name)
	{
		$modelTaximeter = new Application_Model_DbTable_TaximeterModel();
		return $modelTaximeter->fetchAll($modelTaximeter->select()->where('name LIKE ?', '%'.$name.'%'));
	}

}

