<?php

class Application_Model_Clandestine
{

	public function newClandestine($data)
	{
    $authNamespace = new Zend_Session_Namespace('userInformation');
		$clandestine = new Application_Model_DbTable_Clandestine();
		$clandestineRow = $clandestine->createRow();
		$clandestineRow->date = new Zend_Db_Expr('NOW()');
		$clandestineRow->inspector = $authNamespace->user_id; 
		$clandestineRow->local = $data['local'];
		$clandestineRow->clandestine_date = Application_Model_General::dateToUs($data['clandestine_date']);
		$clandestineRow->driver = $data['driver'];
		$clandestineRow->vehicle_model = $data['vehicle_model'];
		$clandestineRow->vehicle_brand = $data['vehicle_brand'];
		$clandestineRow->cnh = $data['cnh'];
		$clandestineRow->info = $data['info'];
		return $clandestineRow->save();
	}

	public function editClandestine($data,$clandestineId)
	{
		$authNamespace = new Zend_Session_Namespace('userInformation');
		$clandestine = new Application_Model_DbTable_Clandestine();
		$clandestineRow = $clandestine->fetchRow($clandestine->select()->where('id = ?',$clandestineId));
		$clandestineRow->date = new Zend_Db_Expr('NOW()');
		$clandestineRow->inspector = $authNamespace->user_id; 
		$clandestineRow->local = $data['local'];
		$clandestineRow->clandestine_date = Application_Model_General::dateToUs($data['clandestine_date']);
		$clandestineRow->driver = $data['driver'];
		$clandestineRow->vehicle_model = $data['vehicle_model'];
		$clandestineRow->vehicle_brand = $data['vehicle_brand'];
		$clandestineRow->cnh = $data['cnh'];
		$clandestineRow->info = $data['info'];
		return $clandestineRow->save();
	}

	public function lists()
	{
		$clandestine = new Application_Model_DbTable_Clandestine();
		$select = $clandestine->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'clandestine'), array('clandestine_id' => 'id', 'local', 'driver',
															'clandestine_date' => new Zend_Db_Expr ('DATE_FORMAT(clandestine_date,"%d/%m/%Y")') ) );
		return $clandestine->fetchAll($select);
	}

	public function returnById($clandestineId)
	{
		$clandestine = new Application_Model_DbTable_Clandestine();
		$select = $clandestine->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'clandestine'), array(	'clandestine_id' => 'id', 'local', 'info', 'driver', 'cnh', 'vehicle_brand', 'vehicle_model',
																											'clandestine_date' => new Zend_Db_Expr ('DATE_FORMAT(clandestine_date,"%d/%m/%Y")') ) )
						->where('c.id = ?',$clandestineId);
		return $clandestine->fetchRow($select);
	}

	public function findByLocal($local)
	{
		$clandestine = new Application_Model_DbTable_Clandestine();
		$select = $clandestine->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'clandestine'), array(	'clandestine_id' => 'id', 'local', 'info', 'driver', 'cnh', 'vehicle_brand', 'vehicle_model',
																											'clandestine_date' => new Zend_Db_Expr ('DATE_FORMAT(clandestine_date,"%d/%m/%Y")') ) )
						->where('c.local LIKE ?','%'.$local.'%');
		return $clandestine->fetchAll($select);
	}

  public function findByDate($date)
  {
  	$clandestine = new Application_Model_DbTable_Clandestine();
		$select = $clandestine->select()->setIntegrityCheck(false);
		$select	->from(array('c' => 'clandestine'), array(	'clandestine_id' => 'id', 'local', 'info', 'driver', 'cnh', 'vehicle_brand', 'vehicle_model',
																											'clandestine_date' => new Zend_Db_Expr ('DATE_FORMAT(clandestine_date,"%d/%m/%Y")') ) )
						->where('c.clandestine_date = ?', Application_Model_General::dateToUs($date));
		return $clandestine->fetchAll($select);
  }
}

