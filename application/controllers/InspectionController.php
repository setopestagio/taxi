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


}









