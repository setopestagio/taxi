<?php

class GranteeController extends Zend_Controller_Action
{

    public function init()
    {
      $this->_helper->layout()->setLayout('dashboard');
  		$authNamespace = new Zend_Session_Namespace('userInformation');
  		$this->view->institution = $authNamespace->institution;
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
      $this->view->vehicleModel = $vehicleModel->fetchAll($vehicleModel->select()->limit('name'));
    }

    public function editAction()
    {
      try{
        $granteeId = $this->getRequest()->getParam('id');
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
      }catch(Zend_Exception $e){
        $this->view->error = true;
      }
      $vehicleModel = new Application_Model_DbTable_VehicleModel();
      $this->view->vehicleModel = $vehicleModel->fetchAll($vehicleModel->select()->limit('name'));
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
        // action body
    }

    public function printLicenseAction()
    {
      $this->_helper->layout()->setLayout('dashboard');
    }

    public function printDataAction()
    {
      try{
        $this->_helper->layout()->setLayout('ajax');
        $id = $this->getRequest()->getParam('id');
        $grantee = new Application_Model_Grantee();
        $print = new Application_Model_PrintData();
        $granteeRow = $grantee->returnById($id);
        $pdf = $print->createPdf($granteeRow);
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


}





















