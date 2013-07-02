<?php

class InspectionController extends Zend_Controller_Action
{

    public function init()
    {
      $this->_helper->layout()->setLayout('dashboard');
    }

    public function indexAction()
    {
        // action body
    }

    public function newAction()
    {
      $this->view->form = new Application_Form_Inspection();
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $inspection = new Application_Model_Inspection();
          if($inspection->newInspection($data) > 0)
          {
            $this->view->success = true;
          }
          else
          {
            $this->view->error = true;
            $this->view->form->populate($data);
          }
        }
      }catch(Zend_Exception $e){
        $this->view->error = true;
      }
    }

    public function editAction()
    {
      $inspection = new Application_Model_Inspection();
      $inspectionId = $this->getRequest()->getParam('id');
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $inspection = new Application_Model_Inspection();
          if($inspection->editInspection($data,$inspectionId) > 0)
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
      $data = $inspection->returnById($inspectionId);
      $this->view->form = new Application_Form_Inspection();
      $this->view->form->reset();
      $this->view->form->populate($data->toArray());
    }

    public function viewAction()
    {
      $inspection = new Application_Model_Inspection();
      $pagination = new Application_Model_Pagination();
      $field = $this->getRequest()->getParam('field');
      $optionSearch = $this->getRequest()->getParam('optionSearch');
      $page = $this->getRequest()->getParam('page');
      if($page == '') $page = 1;
      if($field != "" && ($optionSearch <= 3 && $optionSearch >= 1))
      {
        if($optionSearch == 1)
        {
          $inspections = $inspection->findByLocal(urldecode($field));
        }
        if($optionSearch == 2)
        {
          $inspections = $inspection->findByPermission(urldecode($field));
        }
        if($optionSearch == 3)
        {
          $inspections = $inspection->findByDate(urldecode($field));
        }
        $this->view->list = $pagination->generatePagination($inspections,$page,10);
        $this->view->field = $field;
        $this->view->optionSearch = $optionSearch;
      }
      else
      {
        $inspections = $inspection->lists();
        $this->view->list = $pagination->generatePagination($inspections,$page,10);
      }
    }

    public function removeAction()
    {
        // action body
    }


}









