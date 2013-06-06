<?php

class DashboardController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->setLayout('dashboard');
  		$authNamespace = new Zend_Session_Namespace('userInformation');
  		$this->view->institution = $authNamespace->institution;
    }

    public function indexAction()
    {
        // action body
    }


}

