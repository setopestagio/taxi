<?php

class Application_Model_TaximeterBrand
{

	public function newBrandTaximeter($data)
	{
		$brandTaximeter = new Application_Model_DbTable_TaximeterBrand();
		$brandTaximeterRow = $brandTaximeter->createRow();
		$brandTaximeterRow->name = $data['name'];
		return $brandTaximeterRow->save();
	}

	public function lists()
	{
		$brandTaximeter = new Application_Model_DbTable_TaximeterBrand();
		return $brandTaximeter->fetchAll();
	}

	public function editBrandTaximeter($data,$brandTaximeterId)
	{
		$brandTaximeter = new Application_Model_DbTable_TaximeterBrand();
		$brandTaximeterRow = $brandTaximeter->fetchRow($brandTaximeter->select()->where('id = ?',$brandTaximeterId));
		if($brandTaximeterRow)
		{
			$brandTaximeterRow->name = $data['name'];
			return $brandTaximeterRow->save();
		}
		return false;
	}

	public function returnById($brandTaximeterId)
	{
		$brandTaximeter = new Application_Model_DbTable_TaximeterBrand();
		$select = $brandTaximeter->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'taximeter_brand'));
		return $brandTaximeter->fetchRow($brandTaximeter->select()->where('id = ?',$brandTaximeterId));
	}

	public function findByName($name)
	{
		$brandTaximeter = new Application_Model_DbTable_TaximeterBrand();
		return $brandTaximeter->fetchAll($brandTaximeter->select()->where('name LIKE ?', '%'.$name.'%'));
	}

}

