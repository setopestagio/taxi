<?php

class Application_Form_Assessment extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->setIsArray(true);

      $this->addElement('text', 'vehicle', array(
      		'label'							=> 'Placa do Veículo',
          'placeholder'   		=> 'placa do veículo',
          'class'							=> 'form-control plate'
      ));

      $this->addElement('text', 'grantee', array(
      		'label'							=> 'Permissionário',
          'placeholder'  			=> 'permissionário',
          'class'							=> 'form-control grantee'
      ));

      $this->addElement('text', 'date', array(
      		'label'							=> 'Data',
          'placeholder'   		=> 'data da autuação',
          'class'							=> 'form-control',
          'data-date'					=> date('d/m/Y'),
          'data-date-format'	=> 'dd/mm/yyyy'
      ));

      $this->addElement('select','status', array(
      		'label'							=> 'Status',
          'class'							=> 'form-control',
      		'MultiOptions'			=> array(
      																	0 => '-- Selecione um status --',
      																	1 => 'Aberto', 
      																	2 => 'Processado',
      																	3	=> 'Andamento',
      																	4 => 'Concluído',
      																	5	=> 'Aguardando pagamento',
      																	6	=> 'Pagamento realizado'
      																)
    	));

      $this->addElement('submit', 'submit', array(
        'buttonType' 					=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      					=> 'Salvar',
        'class'           => 'col-lg-offset-5'
      ));
    }


}

