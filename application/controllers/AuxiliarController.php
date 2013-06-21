<?php

class AuxiliarController extends Zend_Controller_Action
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
        // action body
    }

    public function editAction()
    {
      try{
        $auxiliarId = $this->getRequest()->getParam('id');
        $auxiliar = new Application_Model_Auxiliar();
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          if($auxiliar->editAuxiliar($data,$auxiliarId))
          {
             $this->view->success = true;
          }
          else
          {
            $this->view->error = true;
          }
        }
        $this->view->auxiliar = $auxiliar->returnById($auxiliarId);
      }catch(Zend_Exception $e){
        $this->view->error = true;
      }
    }

    public function removeAction()
    {
        // action body
    }

    public function viewAction()
    {
      $auxiliar = new Application_Model_Auxiliar();
      $pagination = new Application_Model_Pagination();
      $field = $this->getRequest()->getParam('field');
      $optionSearch = $this->getRequest()->getParam('optionSearch');
      $page = $this->getRequest()->getParam('page');
      if($page == '') $page = 1;
      if($field != "" && ($optionSearch <= 3 && $optionSearch >= 1))
      {
        if($optionSearch == 2)
        {
          $auxiliars = $auxiliar->findByCPF(urldecode($field));
        }
        if($optionSearch == 3)
        {
          $auxiliars = $auxiliar->findByName(urldecode($field));
        }
        $this->view->list = $pagination->generatePagination($auxiliars,$page,10);
        $this->view->field = $field;
        $this->view->optionSearch = $optionSearch;
      }
      else
      {
        $auxiliars = $auxiliar->lists();
        $this->view->list = $pagination->generatePagination($auxiliars,$page,10);
      }
    }

    public function reportAction()
    {
        // action body
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
        $auxiliar = new Application_Model_Auxiliar();
        $print = new Application_Model_PrintLicense();
        $auxiliarRow = $auxiliar->returnById($id);
        $pdf = $print->createPdf($auxiliarRow,$endDate);
        header('Content-Type: application/pdf');
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }


}













