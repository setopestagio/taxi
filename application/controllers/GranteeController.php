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
        echo $e->getMessage();
      }
    }

    public function removeAction()
    {
        // action body
    }

    public function viewAction()
    {
      $grantee = new Application_Model_Grantee();
      $permission = $this->getRequest()->getParam('permission');
      if($permission != "")
      {
        $this->view->list = $grantee->findByPermission(urldecode($permission));
        $this->view->permission = $permission;
      }
      else
      {
        $this->view->list = $grantee->lists();
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


}













