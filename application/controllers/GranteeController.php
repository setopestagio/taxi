<?php

class GranteeController extends Zend_Controller_Action
{

    public function init()
    {
      $this->_helper->layout()->setLayout('dashboard');
  		$authNamespace = new Zend_Session_Namespace('userInformation');
  		if($authNamespace->institution != 1)
      {
          $this->_redirect('/doesntallow');
      }
    }

    public function indexAction()
    {
        // action body
    }

    public function newAction()
    {
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $grantee = new Application_Model_Grantee();
          if($grantee->newGrantee($data) > 0)
          {
            $this->view->success = true;
          }
          else
          {
            $this->view->error = true;
          }
        }
      }catch(Zend_Exception $e){
        $this->view->error = true;
      }
      $vehicleModel = new Application_Model_DbTable_VehicleModel();
      $this->view->vehicleModel = $vehicleModel->fetchAll($vehicleModel->select()->order('name'));
      $vehicleBrand = new Application_Model_DbTable_VehicleBrand();
      $this->view->vehicleBrand = $vehicleBrand->fetchAll($vehicleBrand->select()->order('name'));
      $city = new Application_Model_DbTable_City();
      $this->view->cities = $city->fetchAll($city->select()->order('name'));
      $modelTaximeter = new Application_Model_DbTable_TaximeterModel();
      $this->view->modelTaximeter = $modelTaximeter->fetchAll($modelTaximeter->select()->order('name'));
      $brandTaximeter = new Application_Model_DbTable_TaximeterModel();
      $this->view->brandTaximeter = $brandTaximeter->fetchAll($brandTaximeter->select()->order('name'));
    }

    public function editAction()
    {
      try{
        $granteeId = $this->getRequest()->getParam('id');
        $save = $this->getRequest()->getParam('save');
        $grantee = new Application_Model_Grantee();
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          if($grantee->editGrantee($data,$granteeId))
          {
             $this->view->success = true;
          }
          else
          {
            $this->view->error = true;
          }
        }
        $this->view->grantee = $grantee->returnById($granteeId);
        $this->view->auxiliars = $grantee->returnAuxiliars($granteeId);
        $this->view->auxiliarsInactives = $grantee->returnAuxiliarsInactives($granteeId);
        // $this->view->reservation = $grantee->returnReservation($granteeId);
        $this->view->reservationHistoric = $grantee->returnReservationHistoric($granteeId);
        $this->view->permissionsHistoric = $grantee->returnPermissionsHistoric($granteeId);
      }catch(Zend_Exception $e){
        $this->view->error = true;
      }
      if( isset($save) && $save == "success" )
      {
        $this->view->success = true;
      }
      if( isset($save) && $save == "failure" )
      {
        $this->view->error = true;
      }
      $vehicleModel = new Application_Model_DbTable_VehicleModel();
      $this->view->vehicleModel = $vehicleModel->fetchAll($vehicleModel->select()->order('name'));
      $vehicleBrand = new Application_Model_DbTable_VehicleBrand();
      $this->view->vehicleBrand = $vehicleBrand->fetchAll($vehicleBrand->select()->order('name'));
      $city = new Application_Model_DbTable_City();
      $this->view->cities = $city->fetchAll($city->select()->order('name'));
      $modelTaximeter = new Application_Model_DbTable_TaximeterModel();
      $this->view->modelTaximeter = $modelTaximeter->fetchAll($modelTaximeter->select()->order('name'));
      $brandTaximeter = new Application_Model_DbTable_TaximeterBrand();
      $this->view->brandTaximeter = $brandTaximeter->fetchAll($brandTaximeter->select()->order('name'));
      $this->view->aux = array( 'grantee' => $granteeId );
      $this->view->reservation = new Application_Form_Reservation();
    }

    public function removeAction()
    {
        // action body
    }

    public function viewAction()
    {
      $grantee = new Application_Model_Grantee();
      $pagination = new Application_Model_Pagination();
      $field = $this->getRequest()->getParam('field');
      $optionSearch = $this->getRequest()->getParam('optionSearch');
      $page = $this->getRequest()->getParam('page');
      if($page == '') $page = 1;
      if($field != "" && ($optionSearch <= 3 && $optionSearch >= 1))
      {
        if($optionSearch == 1)
        {
          $grantees = $grantee->findByPermission(urldecode($field));
        }
        if($optionSearch == 2)
        {
          $grantees = $grantee->findByCPF(urldecode($field));
        }
        if($optionSearch == 3)
        {
          $grantees = $grantee->findByName(urldecode($field));
        }
        $this->view->list = $pagination->generatePagination($grantees,$page,10);
        $this->view->field = $field;
        $this->view->optionSearch = $optionSearch;
      }
      else
      {
        $grantess = $grantee->lists();
        $this->view->list = $pagination->generatePagination($grantess,$page,10);
      }
    }

    public function reportAction()
    {
        // action body
    }

    public function visAction()
    {
      $this->_helper->layout()->setLayout('vis');
    }

    public function printLicenseAction()
    {
      try{
        $this->_helper->layout()->setLayout('ajax');
        $id = $this->getRequest()->getParam('id');
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $endDate = $data['end_date'];
        }
        $grantee = new Application_Model_Grantee();
        $print = new Application_Model_PrintLicense();
        $granteeRow = $grantee->returnById($id);
        $pdf = $print->createPdf($granteeRow,$endDate);
        header('Content-Type: application/pdf');
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function printDataAction()
    {
      try{
        $this->_helper->layout()->setLayout('ajax');
        $id = $this->getRequest()->getParam('id');
        $grantee = new Application_Model_Grantee();
        $print = new Application_Model_PrintData();
        $granteeRow = $grantee->returnById($id);
        $auxiliars = $grantee->returnAuxiliars($id);
        $reservation = $grantee->returnReservationActive($id);
        $pdf = $print->createPdf($granteeRow,$auxiliars,$reservation);
        header('Content-Type: application/pdf');
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function reportGranteeAllAction()
    {
      header('Content-Type: application/pdf');
      $this->_helper->layout()->setLayout('ajax');
      $grantee = new Application_Model_Grantee();
      $grantees = $grantee->findAll();
      $report = new Application_Model_ReportGranteeAll('PERMISSIONÁRIOS');
      $report->create($grantees);
    }

    public function reportGranteeActivesAction()
    {
      header('Content-Type: application/pdf');
      $this->_helper->layout()->setLayout('ajax');
      $grantee = new Application_Model_Grantee();
      $grantees = $grantee->findActives();
      $report = new Application_Model_ReportGranteeActives('PERMISSIONÁRIOS ATIVOS');
      $report->create($grantees);
    }

    public function returnPeopleAction()
    {
      $this->_helper->layout()->setLayout('ajax');
      header('Content-Type: application/json');
      $grantee = new Application_Model_Grantee();
      $result = $grantee->findAuxByName($_GET['query']);
      echo Zend_Json::encode($result);
    }

    public function extractPendenciesAction()
    {
      try{
        $id = $this->getRequest()->getParam('id');
        header('Content-Type: application/pdf');
        $this->_helper->layout()->setLayout('ajax');
        $grantee = new Application_Model_Grantee();
        $granteeRow = $grantee->returnById($id);
        $pendencies = $grantee->returnPendencies($id);
        $auxiliars = $grantee->returnAuxiliars($id);
        $print = new Application_Model_PrintPendencies();
        $pdf = $print->createPdf($granteeRow,$pendencies,$auxiliars);
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function saveAuxiliarAction()
    {
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        $grantee = new Application_Model_Grantee();
        $granteeId = $this->getRequest()->getParam('id');
        if($grantee->saveAuxiliars($data,$granteeId))
        {
          $this->_redirect('/grantee/edit/id/'.$granteeId.'/save/success');
        }
        else
        {
          $this->_redirect('/grantee/edit/id/'.$granteeId.'/save/failure');
        }
      }
    }

    public function removeAuxiliarAction()
    {
      $this->_helper->layout()->setLayout('ajax');
      if ( $this->getRequest()->isPost() ) 
      {
        $grantee = new Application_Model_Grantee();
        $data = $this->getRequest()->getPost();
        echo $grantee->removeAuxiliar($data['granteeId'],$data['idAux'],$data['endDate']);
      }
      echo false;
    }

    public function reservationAction()
    {
      $this->_helper->layout()->setLayout('ajax');
      if ( $this->getRequest()->isPost() ) 
      {
        $grantee = new Application_Model_Grantee();
        $data = $this->getRequest()->getPost();
        if($grantee->saveReservation($data))
        {
          $this->_redirect('/grantee/edit/id/'.$data['grantee'].'/save/success');
        }
        else
        {
          $this->_redirect('/grantee/edit/id/'.$data['grantee'].'/save/failure');
        }
      }
    }

    public function reservationLicenseAction()
    {
      try{
        $id = $this->getRequest()->getParam('id');
        header('Content-Type: application/pdf');
        $this->_helper->layout()->setLayout('ajax');
        $grantee = new Application_Model_Grantee();
        $print = new Application_Model_PrintReservation();
        $reservation = $grantee->returnReservation($id);
        $granteeRow = $grantee->returnById($reservation->grantee);
        $pdf = $print->createPdf($granteeRow,$reservation);
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function excludeAuxiliarAction()
    {
      $this->_helper->layout()->setLayout('ajax');
      if ( $this->getRequest()->isPost() ) 
      {
        $grantee = new Application_Model_Grantee();
        $data = $this->getRequest()->getPost();
        if($grantee->excludeAuxiliar($data['excludeGranteeAuxiliar']))
        {
          $this->_redirect('/grantee/edit/id/'.$data['excludeGranteeId'].'/save/success');
        }
        else
        {
          $this->_redirect('/grantee/edit/id/'.$data['excludeGranteeId'].'/save/failure');
        }
      }
    }

    public function printCommunicationAction()
    {
      try{
        $this->_helper->layout()->setLayout('ajax');
        $id = $this->getRequest()->getParam('id');
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
        }
        $grantee = new Application_Model_Grantee();
        $print = new Application_Model_PrintCommunication();
        $granteeRow = $grantee->returnById($id);
        $pdf = $print->createPdf($granteeRow,$data);
        header('Content-Type: application/pdf');
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function editAuxiliarAction()
    {
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        $grantee = new Application_Model_Grantee();
        if($grantee->editAuxiliar($data))
        {
          $this->_redirect('/grantee/edit/id/'.$data['grantee_id'].'/save/success');
        }
        else
        {
          $this->_redirect('/grantee/edit/id/'.$data['grantee_id'].'/save/failure');
        }
      }
    }

    public function reportVehicleAction()
    {
      try{
        header('Content-Type: application/pdf');
        $this->_helper->layout()->setLayout('ajax');
        $id = $this->getRequest()->getParam('id');
        $print = new Application_Model_PrintVehicle('FROTA');
        $vehicle = new Application_Model_Vehicle();
        $fleet = $vehicle->returnAll();
        $pdf = $print->createPdf($fleet);
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function newHistoricAction()
    {
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $grantee = new Application_Model_Grantee();
          if($grantee->newHistoric($data))
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/success');
          }
          else
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
          }
        }
      }catch(Zend_Exception $e){
          $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
      }
    }

    public function editHistoricAction()
    {
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $grantee = new Application_Model_Grantee();
          if($grantee->editHistoric($data,$data['id']))
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/success');
          }
          else
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
          }
        }
      }catch(Zend_Exception $e){
          $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
      }
    }

    public function removeHistoricAction()
    {
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $grantee = new Application_Model_Grantee();
          if($grantee->removeHistoric($data['id']))
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/success');
          }
          else
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
          }
        }
      }catch(Zend_Exception $e){
          $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
      }
    }

    public function addAuxiliarHistoricAction()
    {
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $grantee = new Application_Model_Grantee();
          if($grantee->addAuxiliarHistoric($data))
          {
            $this->_redirect('/grantee/edit/id/'.$data['grantee_id'].'/save/success');
          }
          else
          {
            $this->_redirect('/grantee/edit/id/'.$data['grantee_id'].'/save/failure');
          }
        }
      }catch(Zend_Exception $e){
          $this->_redirect('/grantee/edit/id/'.$data['grantee_id'].'/save/failure');
      }
    }

    public function editAuxiliarHistoricAction()
    {
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $grantee = new Application_Model_Grantee();
          if($grantee->editAuxiliarHistoric($data))
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/success');
          }
          else
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
          }
        }
      }catch(Zend_Exception $e){
          $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
      }
    }

    public function removeAuxiliarHistoricAction()
    {
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $grantee = new Application_Model_Grantee();
          if($grantee->removeAuxiliarHistoric($data))
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/success');
          }
          else
          {
            $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
          }
        }
      }catch(Zend_Exception $e){
          $this->_redirect('/grantee/edit/id/'.$data['owner'].'/save/failure');
      }
    }


}





















































