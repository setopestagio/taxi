<?php

class AssessmentController extends Zend_Controller_Action
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
      $this->view->form = new Application_Form_Assessment();
    }

    public function editAction()
    {
        // action body
    }

    public function viewAction()
    {
        // action body
    }

    public function removeAction()
    {
        // action body
    }

    public function reportAction()
    {
        // action body
    }

    public function returnGranteeAction()
    {
      $this->_helper->layout()->setLayout('ajax');
      header('Content-Type: application/json');
      $grantee = new Application_Model_Assessment();
      $result = $grantee->findGranteeByName($_GET['query']);
      echo Zend_Json::encode($result);
    }

    public function calendarAction()
    {
        // action body
    }


}















