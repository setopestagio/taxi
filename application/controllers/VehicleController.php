<?php

class VehicleController extends Zend_Controller_Action
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
        // action body
    }

    public function editAction()
    {
        // action body
    }

    public function removeAction()
    {
        // action body
    }

    public function visAction()
    {
        // action body
    }


}









