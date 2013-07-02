<?php

class Application_Model_Inspection
{

	public function newInspection($data)
	{
    $authNamespace = new Zend_Session_Namespace('userInformation');
		$inspection = new Application_Model_DbTable_Inspection();
		$inspectionRow = $inspection->createRow();
		$inspectionRow->date = new Zend_Db_Expr('NOW()');
		$inspectionRow->inspector = $authNamespace->user_id; 
		$inspectionRow->local = $data['local'];
		$inspectionRow->inspection_date = Application_Model_General::dateToUs($data['inspection_date']);
		$grantee = new Application_Model_Grantee();
		$granteeRow = $grantee->findByPermission($data['permission']);
		$inspectionRow->grantee = $granteeRow[0]['id'];
		$vehicle = new Application_Model_Vehicle();
		$vehicleRow = $vehicle->returnByPlate($data['plate']);
		$inspectionRow->vehicle = $vehicleRow->id;
		$inspectionRow->info = $data['info'];
		$inspectionRow->infraction = $data['infraction'];
		return $inspectionRow->save();
	}

	public function editInspection($data,$inspectionId)
	{
		$authNamespace = new Zend_Session_Namespace('userInformation');
		$inspection = new Application_Model_DbTable_Inspection();
		$inspectionRow = $inspection->fetchRow($inspection->select()->where('id = ?',$inspectionId));
		$inspectionRow->date = new Zend_Db_Expr('NOW()');
		$inspectionRow->inspector = $authNamespace->user_id; 
		$inspectionRow->local = $data['local'];
		$inspectionRow->inspection_date = Application_Model_General::dateToUs($data['inspection_date']);
		$grantee = new Application_Model_Grantee();
		$granteeRow = $grantee->findByPermission($data['permission']);
		$inspectionRow->grantee = $granteeRow[0]['id'];
		$vehicle = new Application_Model_Vehicle();
		$vehicleRow = $vehicle->returnByPlate($data['plate']);
		$inspectionRow->vehicle = $vehicleRow->id;
		$inspectionRow->info = $data['info'];
		$inspectionRow->infraction = $data['infraction'];
		return $inspectionRow->save();
	}

	public function lists()
	{
		$inspection = new Application_Model_DbTable_Inspection();
		$select = $inspection->select()->setIntegrityCheck(false);
		$select	->from(array('g' => 'inspection'), array('inspection_id' => 'id', 'local',
															'inspection_date' => new Zend_Db_Expr ('DATE_FORMAT(inspection_date,"%d/%m/%Y")') ) )
						->joinInner(array('p' => 'person'),'p.id=g.grantee');
		return $inspection->fetchAll($select);
	}

	public function returnById($inspectionId)
	{
		$inspection = new Application_Model_DbTable_Inspection();
		$select = $inspection->select()->setIntegrityCheck(false);
		$select	->from(array('i' => 'inspection'), array(	'inspection_id' => 'id', 'local', 'info',
																											'inspection_date' => new Zend_Db_Expr ('DATE_FORMAT(inspection_date,"%d/%m/%Y")') ) )
						->joinInner(array('g' => 'grantee'),'g.id=i.grantee',array('permission') )
						->joinInner(array('v' => 'vehicle'),'v.id=g.vehicle',array('plate') )
						->where('i.id = ?',$inspectionId);
		return $inspection->fetchRow($select);
	}

	public function findByLocal($local)
	{
		$inspection = new Application_Model_DbTable_Inspection();
		$select = $inspection->select()->setIntegrityCheck(false);
		$select	->from(array('i' => 'inspection'), array(	'inspection_id' => 'id', 'local', 'info',
																											'inspection_date' => new Zend_Db_Expr ('DATE_FORMAT(inspection_date,"%d/%m/%Y")') ) )
						->joinInner(array('g' => 'grantee'),'g.id=i.grantee',array('permission') )
						->joinInner(array('p' => 'person'),'p.id=g.owner')
						->joinInner(array('v' => 'vehicle'),'v.id=g.vehicle',array('plate') )
						->where('i.local LIKE ?','%'.$local.'%');
		return $inspection->fetchAll($select);
	}

  public function findByPermission($permission)
  {
		$inspection = new Application_Model_DbTable_Inspection();
		$select = $inspection->select()->setIntegrityCheck(false);
		$select	->from(array('i' => 'inspection'), array(	'inspection_id' => 'id', 'local', 'info',
																											'inspection_date' => new Zend_Db_Expr ('DATE_FORMAT(inspection_date,"%d/%m/%Y")') ) )
						->joinInner(array('g' => 'grantee'),'g.id=i.grantee',array('permission') )
						->joinInner(array('p' => 'person'),'p.id=g.owner')
						->joinInner(array('v' => 'vehicle'),'v.id=g.vehicle',array('plate') )
						->where('g.permission = ?',$permission);
		return $inspection->fetchAll($select);
  }

  public function findByDate($date)
  {
  	$inspection = new Application_Model_DbTable_Inspection();
		$select = $inspection->select()->setIntegrityCheck(false);
		$select	->from(array('i' => 'inspection'), array(	'inspection_id' => 'id', 'local', 'info',
																											'inspection_date' => new Zend_Db_Expr ('DATE_FORMAT(inspection_date,"%d/%m/%Y")') ) )
						->joinInner(array('g' => 'grantee'),'g.id=i.grantee',array('permission') )
						->joinInner(array('p' => 'person'),'p.id=g.owner')
						->joinInner(array('v' => 'vehicle'),'v.id=g.vehicle',array('plate') )
						->where('i.inspection_date = ?', Application_Model_General::dateToUs($date));
		return $inspection->fetchAll($select);
  }
}

