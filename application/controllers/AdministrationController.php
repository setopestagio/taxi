<?php

class AdministrationController extends Zend_Controller_Action
{

    public function init()
    {
      $this->_helper->layout()->setLayout('dashboard');
      $authNamespace = new Zend_Session_Namespace('userInformation');
      $this->view->institution = $authNamespace->institution;
      $this->view->userId = $authNamespace->user_id; 
      if($this->view->userId != 1 && $this->view->userId != 5 && $this->view->userId != 9)
      {
      	$this->_redirect('/doesntallow');
      }
    }

    public function indexAction()
    {
        // action body
    }

    public function inspectorAction()
    {
      if($this->view->institution != 2)
      {
      	$this->_redirect('/doesntallow');
      }
      $inspector = new Application_Model_Inspector();
      $pagination = new Application_Model_Pagination();
      $field = $this->getRequest()->getParam('field');
      $optionSearch = $this->getRequest()->getParam('optionSearch');
      $page = $this->getRequest()->getParam('page');
      if($page == '') $page = 1;
      if($field != "" && ($optionSearch <= 3 && $optionSearch >= 1))
      {
        if($optionSearch == 1)
        {
          $inspectors = $inspector->findByMASP(urldecode($field));
        }
        if($optionSearch == 2)
        {
          $inspectors = $inspector->findByCPF(urldecode($field));
        }
        if($optionSearch == 3)
        {
          $inspectors = $inspector->findByName(urldecode($field));
        }
        $this->view->list = $pagination->generatePagination($inspectors,$page,10);
        $this->view->field = $field;
        $this->view->optionSearch = $optionSearch;
      }
      else
      {
        $inspector = $inspector->lists();
        $this->view->list = $pagination->generatePagination($inspector,$page,10);
      }
    }

    public function inspectorNewAction()
    {
      if($this->view->institution != 2)
      {
      	$this->_redirect('/doesntallow');
      }
      $this->view->form = new Application_Form_Inspector();
     	if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        $inspector = new Application_Model_Inspector();
        if($inspector->newInspector($data))
        {
        	$this->view->success = true;
        }
        else
        {
          $this->view->form->populate($data);
        	$this->view->error = true;
        }
      }
    }

    public function inspectorEditAction()
    {
      if($this->view->institution != 2)
      {
      	$this->_redirect('/doesntallow');
      }
      $userId = $this->getRequest()->getParam('id');
      $save = $this->getRequest()->getParam('save');
      $user = new Application_Model_Inspector();
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        if($user->editUser($data,$userId))
        {
           $this->view->success = true;
        }
        else
        {
          $this->view->error = true;
        }
      }
      $this->view->user = $user->returnById($userId);
    }

    public function userAction()
    {
      if($this->view->institution != 1)
      {
        $this->_redirect('/doesntallow');
      }
      $user = new Application_Model_User();
      $pagination = new Application_Model_Pagination();
      $field = $this->getRequest()->getParam('field');
      $page = $this->getRequest()->getParam('page');
      if($page == '') $page = 1;
      if($field != "")
      {
        $users = $user->findByName(urldecode($field));
        $this->view->list = $pagination->generatePagination($users,$page,10);
        $this->view->field = $field;
      }
      else
      {
        $user = $user->lists();
        $this->view->list = $pagination->generatePagination($user,$page,10);
      }
    }

    public function userNewAction()
    {
      if($this->view->institution != 1)
      {
        $this->_redirect('/doesntallow');
      }
      $this->view->form = new Application_Form_User();
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        $inspector = new Application_Model_User();
        if($inspector->newUser($data))
        {
          $this->view->success = true;
        }
        else
        {
          $this->view->form->populate($data);
          $this->view->error = true;
        }
      }
    }

    public function userEditAction()
    {
      if($this->view->institution != 1)
      {
        $this->_redirect('/doesntallow');
      }
      $userId = $this->getRequest()->getParam('id');
      $save = $this->getRequest()->getParam('save');
      $user = new Application_Model_User();
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        if($user->editUser($data,$userId))
        {
           $this->view->success = true;
        }
        else
        {
          $this->view->error = true;
        }
      }
      $this->view->form = new Application_Form_User();
      $user = $user->returnById($userId);
      unset($user->password);
      $this->view->form->reset();
      $this->view->form->populate($user->toArray());
    }

    public function cityAction()
    {
      if($this->view->institution != 1)
      {
        $this->_redirect('/doesntallow');
      }
      $city = new Application_Model_City();
      $pagination = new Application_Model_Pagination();
      $field = $this->getRequest()->getParam('field');
      $page = $this->getRequest()->getParam('page');
      if($page == '') $page = 1;
      if($field != "")
      {
        $citys = $city->findByName(urldecode($field));
        $this->view->list = $pagination->generatePagination($citys,$page,10);
        $this->view->field = $field;
      }
      else
      {
        $city = $city->lists();
        $this->view->list = $pagination->generatePagination($city,$page,10);
      }
    }

    public function cityNewAction()
    {
      if($this->view->institution != 1)
      {
        $this->_redirect('/doesntallow');
      }
      $this->view->form = new Application_Form_City();
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        $city = new Application_Model_City();
        if($city->newCity($data))
        {
          $this->view->success = true;
        }
        else
        {
          $this->view->form->populate($data);
          $this->view->error = true;
        }
      }
    }

    public function cityEditAction()
    {
      if($this->view->institution != 1)
      {
        $this->_redirect('/doesntallow');
      }
      $cityId = $this->getRequest()->getParam('id');
      $save = $this->getRequest()->getParam('save');
      $city = new Application_Model_City();
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        if($city->editCity($data,$cityId))
        {
           $this->view->success = true;
        }
        else
        {
          $this->view->error = true;
        }
      }
      $this->view->form = new Application_Form_City();
      $city = $city->returnById($cityId);
      $this->view->form->reset();
      $this->view->form->populate($city->toArray());
    }


}



















