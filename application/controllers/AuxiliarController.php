<?php

class AuxiliarController extends Zend_Controller_Action
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
      try{
        if ($this->getRequest()->isPost()) 
        {
          $data = $this->getRequest()->getPost();
          $auxiliar = new Application_Model_Auxiliar();
          $auxiliarId = $auxiliar->newAuxiliar($data);
          if($auxiliarId)
          {
            if(isset($data['grantee_new_id']) && $data['grantee_new_id'] != '')
            {
              $auxiliar->saveToGrantee($data['grantee_new_id'],$data['start_date_new_grantee'],$auxiliarId);
            }
            $this->view->success = true;
            $this->_redirect('/auxiliar/edit/id/'.$auxiliarId);
          }
          else
          {
            $this->view->error = true;
          }
        }
      }catch(Zend_Exception $e){
        $this->view->error = true;
      }
      $city = new Application_Model_DbTable_City();
      $this->view->cities = $city->fetchAll($city->select()->order('name'));
    }

    public function editAction()
    {
      try{
        $auxiliarId = $this->getRequest()->getParam('id');
        $save = $this->getRequest()->getParam('save');
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
        if( isset($save) && $save == "success" )
        {
          $this->view->success = true;
        }
        if( isset($save) && $save == "failure" )
        {
          $this->view->error = true;
        }
        $this->view->auxiliar = $auxiliar->returnById($auxiliarId);
        $this->view->historicGrantees = $auxiliar->returnGrantees($auxiliarId);
      }catch(Zend_Exception $e){
        $this->view->error = true;
      }
      $city = new Application_Model_DbTable_City();
      $this->view->cities = $city->fetchAll($city->select()->order('name'));
    }

    public function removeAction()
    {
      $id = $this->getRequest()->getParam('id');
      if ( $this->getRequest()->isPost() ) 
      {
        $auxiliar = new Application_Model_Auxiliar();
        if($auxiliar->remove($id))
        {
          $this->_redirect('/auxiliar/view');
        }
        else
        {
           $this->_redirect('/auxiliar/view');
        }
      }
     $this->_redirect('/auxiliar/view');
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
      $city = new Application_Model_DbTable_City();
      $this->view->cities = $city->fetchAll($city->select()->order('name'));
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
        header('Content-Disposition: attachment; filename="Carteira de Auxiliar.pdf"');
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function printDataAction()
    {
      try{
        $this->_helper->layout()->setLayout('ajax');
        $id = $this->getRequest()->getParam('id');
        $auxiliar = new Application_Model_Auxiliar();
        $print = new Application_Model_PrintDataAuxiliar();
        $auxiliarRow = $auxiliar->returnById($id);
        $pdf = $print->createPdf($auxiliarRow);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Dados Auxiliar.pdf"');
        echo $pdf->render(); 
      }catch(Zend_Exception $e){
        die ('PDF error: ' . $e->getMessage()); 
      }catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());    
      }
    }

    public function saveGranteeAction()
    {
      if ( $this->getRequest()->isPost() ) 
      {
        $auxiliar = new Application_Model_Auxiliar();
        $data = $this->getRequest()->getPost();
        if($auxiliar->saveGranteesToAuxiliar($data,$data['aux_id']))
        {
          $this->_redirect('/auxiliar/edit/id/'.$data['aux_id'].'/save/success');
        }
        else
        {
          $this->_redirect('/auxiliar/edit/id/'.$data['aux_id'].'/save/failure');
        }
      }
    }

    public function returnGranteeAction()
    {
      $this->_helper->layout()->setLayout('ajax');
      header('Content-Type: application/json');
      $auxiliar = new Application_Model_Auxiliar();
      $result = $auxiliar->findGranteeByName($_GET['query']);
      echo Zend_Json::encode($result);
    }

    public function removeGranteeAction()
    {
      $auxId = $this->getRequest()->getParam('id');
      if ( $this->getRequest()->isPost() ) 
      {
        $auxiliar = new Application_Model_Auxiliar();
        $data = $this->getRequest()->getPost();
        if($auxiliar->removeGranteesToAuxiliar($data,$auxId))
        {
          $this->_redirect('/auxiliar/edit/id/'.$auxId.'/save/success');
        }
        else
        {
          $this->_redirect('/auxiliar/edit/id/'.$auxId.'/save/failure');
        }
      }
    }

    public function reportAuxiliarAllAction()
    {
      try{
        if($_GET["aux_all"] == 0) // responsavel pelo "PDF"
        {
          $optionCity = $this->getRequest()->getParam('optionCity');
          if($optionCity == 0)
          {
            $this->_helper->layout()->setLayout('report');
            $auxiliar = new Application_Model_Auxiliar();
            $auxiliares = $auxiliar->findAll();
            $this->view->list = $auxiliares;
          }
          else
          {
           $this->_helper->layout()->setLayout('report');
            $auxiliar = new Application_Model_Auxiliar();
            $auxiliares = $auxiliar->findAllCity($optionCity);
            $this->view->list = $auxiliares; 
          }
        }
        else // Responsavel pelo Csv
        {
         $optionCity = $this->getRequest()->getParam('optionCity');
          if($optionCity == 0)
          {
            header('Content-Encoding: utf-8');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_auxiliar_todos.csv');
            echo "\xEF\xBB\xBF";
            $this->_helper->layout()->setLayout('ajax');
            $auxiliar = new Application_Model_Auxiliar();
            $output = fopen('php://output', 'w');
            $auxiliares = $auxiliar->findAll();
            fputcsv($output, array('Nome', 'CPF','RG','Rua','Bairro','Cidade','CEP','Nº da Licença do Permissionário','Data de Inicio na Permissão'),';');
            foreach ($auxiliares as $auxiliaress ){
              fputcsv($output, array($auxiliaress->name, $auxiliaress->cpf, $auxiliaress->rg_completo, $auxiliaress->address_complete, $auxiliaress->neighborhood,
               $auxiliaress->city_address, $auxiliaress->zipcode, $auxiliaress->grantee_permission, $auxiliaress->start_permission),';');
            }
              exit;
          }
          else
          {
            $city = new Application_Model_DbTable_City();
            $chosenCity = $city->fetchRow($city->select()->from(array('c' => 'city'), array('name'))->where('c.id = ?',$optionCity));
            header('Content-Encoding: utf-8');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_auxiliares_'.$chosenCity->name.'.csv');
            echo "\xEF\xBB\xBF";
            $this->_helper->layout()->setLayout('ajax');
            $auxiliar = new Application_Model_Auxiliar();
            $output = fopen('php://output', 'w');
            $auxiliares = $auxiliar->findAllCity($optionCity);
            fputcsv($output, array('Nome', 'CPF','RG','Rua','Bairro','Cidade','CEP','Nº da Licença do Permissionário','Data de Inicio na Permissão'),';');
            foreach ($auxiliares as $auxiliaress ){
              fputcsv($output, array($auxiliaress->name, $auxiliaress->cpf, $auxiliaress->rg_completo, $auxiliaress->address_complete, 
                $auxiliaress->neighborhood, $auxiliaress->city_address, $auxiliaress->zipcode, $auxiliaress->grantee_permission,
                $auxiliaress->start_permission),';');
            }
            exit;
          }
        }
      }catch(Zend_Exception $e){
        echo $e->getMessage();
      }
    }

    public function reportAuxiliarActiveAllAction()
    {
      try{
        if($_GET["aux_all"] == 0) // responsavel pelo "PDF"
        {
          $optionCity = $this->getRequest()->getParam('optionCity');
          if($optionCity == 0)
          {
            $this->_helper->layout()->setLayout('report');
            $auxiliar = new Application_Model_Auxiliar();
            $auxiliares = $auxiliar->findAllActive();
            $this->view->list = $auxiliares;
          }
          else
          {
           $this->_helper->layout()->setLayout('report');
            $auxiliar = new Application_Model_Auxiliar();
            $auxiliares = $auxiliar->findAllActiveCity($optionCity);
            $this->view->list = $auxiliares; 
          }
        }
        else // Responsavel pelo Csv
        {
         $optionCity = $this->getRequest()->getParam('optionCity');
          if($optionCity == 0)
          {
            header('Content-Encoding: utf-8');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_auxiliar_todos_ativos.csv');
            echo "\xEF\xBB\xBF";
            $this->_helper->layout()->setLayout('ajax');
            $auxiliar = new Application_Model_Auxiliar();
            $output = fopen('php://output', 'w');
            $auxiliares = $auxiliar->findAllActive();
            fputcsv($output, array('Nome', 'CPF','RG','Rua','Bairro','Cidade','CEP','Nº da Licença do Permissionário','Data de Inicio na Permissão'),';');
            foreach ($auxiliares as $auxiliaress ){
              fputcsv($output, array($auxiliaress->name, $auxiliaress->cpf, $auxiliaress->rg_completo, $auxiliaress->address_complete, $auxiliaress->neighborhood,
               $auxiliaress->city_address, $auxiliaress->zipcode, $auxiliaress->grantee_permission, $auxiliaress->start_permission),';');
            }
              exit;
          }
          else
          {
            $city = new Application_Model_DbTable_City();
            $chosenCity = $city->fetchRow($city->select()->from(array('c' => 'city'), array('name'))->where('c.id = ?',$optionCity));
            header('Content-Encoding: utf-8');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_auxiliares_ativos_'.$chosenCity->name.'.csv');
            echo "\xEF\xBB\xBF";
            $this->_helper->layout()->setLayout('ajax');
            $auxiliar = new Application_Model_Auxiliar();
            $output = fopen('php://output', 'w');
            $auxiliares = $auxiliar->findAllActiveCity($optionCity);
            fputcsv($output, array('Nome', 'CPF','RG','Rua','Bairro','Cidade','CEP','Nº da Licença do Permissionário','Data de Inicio na Permissão'),';');
            foreach ($auxiliares as $auxiliaress ){
              fputcsv($output, array($auxiliaress->name, $auxiliaress->cpf, $auxiliaress->rg_completo, $auxiliaress->address_complete, 
                $auxiliaress->neighborhood, $auxiliaress->city_address, $auxiliaress->zipcode, $auxiliaress->grantee_permission,
                $auxiliaress->start_permission),';');
            }
            exit;
          }
        }
      }catch(Zend_Exception $e){
        echo $e->getMessage();
      }
    }

    public function reportGranteeAuxiliarActiveAllAction()
    {
        try{
        if($_GET["aux_all"] == 0) // responsavel pelo "PDF"
        {
          $optionCity = $this->getRequest()->getParam('optionCity');
          if($optionCity == 0)
          {
            $this->_helper->layout()->setLayout('report');
            $auxiliar = new Application_Model_Auxiliar();
            $auxiliares = $auxiliar->findGranteeAuxiliarActive($_GET["data_crt"]);
            $this->view->list = $auxiliares;
          }
          else
          {
           $this->_helper->layout()->setLayout('report');
            $auxiliar = new Application_Model_Auxiliar();
            $auxiliares = $auxiliar->findGranteeAuxiliarActiveCity($_GET["data_crt"],$optionCity);
            $this->view->list = $auxiliares; 
          }
        }
        else // Responsavel pelo Csv
        {
         $optionCity = $this->getRequest()->getParam('optionCity');
          if($optionCity == 0)
          {
            header('Content-Encoding: utf-8');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_permissionarios_auxiliares_ativos.csv');
            echo "\xEF\xBB\xBF";
            $this->_helper->layout()->setLayout('ajax');
            $auxiliar = new Application_Model_Auxiliar();
            $output = fopen('php://output', 'w');
            $auxiliares = $auxiliar->findGranteeAuxiliarActive($_GET["data_crt"]);
            fputcsv($output, array('Nº de Auxiliares', 'Nº de Permissionários', 'Data da Pesquisa'),';');
            foreach ($auxiliares as $auxiliaress ){
              fputcsv($output, array($auxiliaress['num_aux'], $auxiliaress['num_grantee'], $auxiliaress['data_pesquisa']),';');
            }
              exit;
          }
          else
          {
            $city = new Application_Model_DbTable_City();
            $chosenCity = $city->fetchRow($city->select()->from(array('c' => 'city'), array('name'))->where('c.id = ?',$optionCity));
            header('Content-Encoding: utf-8');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_permissionarios_auxiliares_ativos_'.$chosenCity->name.'.csv');
            echo "\xEF\xBB\xBF";
            $this->_helper->layout()->setLayout('ajax');
            $auxiliar = new Application_Model_Auxiliar();
            $output = fopen('php://output', 'w');
            $auxiliares = $auxiliar->findGranteeAuxiliarActiveCity($_GET["data_crt"],$optionCity);
            fputcsv($output, array('Nº de Auxiliares', 'Nº de Permissionários', 'Data da Pesquisa'),';');
            foreach ($auxiliares as $auxiliaress ){
              fputcsv($output, array($auxiliaress['num_aux'], $auxiliaress['num_grantee'], $auxiliaress['data_pesquisa']),';');
            }
            exit;
          }
        }
      }catch(Zend_Exception $e){
        echo $e->getMessage();
      }
    }

}





