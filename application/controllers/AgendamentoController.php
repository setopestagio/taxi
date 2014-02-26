<?php

class AgendamentoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
      $scheduling = new Application_Model_Scheduling();
    	if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        $hashCaptcha = $scheduling->rpHash($data['defaultReal']);
        if($hashCaptcha == $data['defaultRealHash']) 
        {
          try{
          	$idSchedule = $scheduling->newSchedule($data);
          	if($idSchedule)
          	{
          		$this->redirect('/agendamento/completo/id/'.base64_encode($idSchedule));
          	}
            else
            {
              $this->redirect('/agendamento/index/save/failed');
            }
          }catch(Zend_Exception $e) {
              $this->redirect('/agendamento/index/save/failed');
          }
        }
        else
        {
          $scheduling->saveError();
        	$this->redirect('/agendamento/index/captcha/failed');
        }
      }
      $this->view->hour = $scheduling->returnHour();
      $this->view->captcha = $this->getRequest()->getParam('captcha');
      $this->view->save = $this->getRequest()->getParam('save');
    }

    public function completoAction()
    {
        // action body
      $id = base64_decode($this->getRequest()->getParam('id'));
      $scheduling = new Application_Model_Scheduling();
      $this->view->info = $scheduling->getInfo($id);
      $this->view->id = $this->getRequest()->getParam('id');
    }

    public function documentosAction()
    {
        // action body
    }

    public function confirmacaoAction()
    {
        // action body
    }

    public function printConfirmationAction()
    {
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment; filename="Agendamento.pdf"');
      $id = base64_decode($this->getRequest()->getParam('id'));
      $confirmation = new Application_Model_PrintConfirmation();
      $pdf = $confirmation->createPdf($id);
      echo $pdf->render(); 
    }

    public function consultaAction()
    {
      $scheduling = new Application_Model_Scheduling();
      if ( $this->getRequest()->isPost() ) 
      {
        $data = $this->getRequest()->getPost();
        $this->view->cpf = $data['cpf'];
        $this->view->schedulings = $scheduling->searchByCPF($data['cpf']);
      }
      $this->view->save = $this->getRequest()->getParam('save');
      $this->view->hour = $scheduling->returnHour();
    }


}











