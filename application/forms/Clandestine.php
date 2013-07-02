<?php

class Application_Form_Clandestine extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->setIsArray(true);

      $this->addElement('text', 'local', array(
      		'label'					=> 'Local',
          'placeholder'   => 'local da fiscalização',
          'class'					=> 'input-xxlarge'
      ));

      $this->addElement('text', 'clandestine_date', array(
      		'label'					=> 'Data',
          'placeholder'   => 'data da fiscalização realizada',
          'class'					=> 'input-xxlarge dateMask datepicker'
      ));

      $this->addElement('text', 'driver', array(
          'label'         => 'Motorista',
          'placeholder'   => 'nome do motorista',
          'class'         => 'input-xxlarge'
      ));

      $this->addElement('text', 'cnh', array(
      		'label'					=> 'CNH',
          'placeholder'   => 'número da cnh',
          'class'					=> 'input-xxlarge'
      ));

     	$this->addElement('select','vehicle_brand', array(
      		'label'							=> 'Marca do Veículo',
          'class'							=> 'input-xxlarge',
      		'MultiOptions'			=> array(
      																	0 => '-- Selecione uma marca --'
      																)
  		));

     	$this->addElement('select','vehicle_model', array(
      		'label'							=> 'Modelo do Veículo',
          'class'							=> 'input-xxlarge',
      		'MultiOptions'			=> array(
      																	1 => '-- Selecione um modelo --'
      																)
  		));

      $this->addElement('textarea', 'info', array(
      		'label'					=> 'Informações Adicionais',
          'placeholder'   => 'informações adicionais',
          'class'					=> 'input-xxlarge',
          'rows'					=> '5'
      ));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar'
      ));
    }


}

