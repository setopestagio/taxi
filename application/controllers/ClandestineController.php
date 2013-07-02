<?php

class ClandestineController extends Zend_Controller_Action
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
      $this->view->form = new Application_Form_Clandestine();
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          $clandestine = new Application_Model_Clandestine();
          if($clandestine->newClandestine($data) > 0)
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
        echo $e->getMessage();
      }
    }

    public function editAction()
    {
      $clandestine = new Application_Model_Clandestine();
      $clandestineId = $this->getRequest()->getParam('id');
      try{
        if ( $this->getRequest()->isPost() ) 
        {
          $data = $this->getRequest()->getPost();
          if($clandestine->editClandestine($data,$clandestineId) > 0)
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
      $data = $clandestine->returnById($clandestineId);
      $this->view->form = new Application_Form_Clandestine();
      $this->view->form->reset();
      $this->view->form->populate($data->toArray());
    }

    public function viewAction()
    {
      $clandestine = new Application_Model_Clandestine();
      $pagination = new Application_Model_Pagination();
      $field = $this->getRequest()->getParam('field');
      $optionSearch = $this->getRequest()->getParam('optionSearch');
      $page = $this->getRequest()->getParam('page');
      if($page == '') $page = 1;
      if($field != "" && ($optionSearch <= 3 && $optionSearch >= 1))
      {
        if($optionSearch == 1)
        {
          $clandestines = $clandestine->findByLocal(urldecode($field));
        }
        if($optionSearch == 2)
        {
          $clandestines = $clandestine->findByDate(urldecode($field));
        }
        $this->view->list = $pagination->generatePagination($clandestines,$page,10);
        $this->view->field = $field;
        $this->view->optionSearch = $optionSearch;
      }
      else
      {
        $clandestines = $clandestine->lists();
        $this->view->list = $pagination->generatePagination($clandestines,$page,10);
      }
    }

    public function removeAction()
    {
        // action body
    }


}









