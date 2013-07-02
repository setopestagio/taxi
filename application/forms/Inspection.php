<?php

class Application_Form_Inspection extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
     	$this->setIsArray(true);

      $this->addElement('text', 'local', array(
      		'label'					=> 'Local',
          'placeholder'   => 'local da fiscalização',
          'class'					=> 'input-xxlarge'
      ));

      $this->addElement('text', 'inspection_date', array(
      		'label'					=> 'Data',
          'placeholder'   => 'data da fiscalização realizada',
          'class'					=> 'input-xxlarge dateMask datepicker'
      ));

      $this->addElement('text', 'permission', array(
          'label'         => 'Permissionário',
          'placeholder'   => 'número da permissão',
          'class'         => 'input-xxlarge permission'
      ));

      $this->addElement('text', 'plate', array(
      		'label'					=> 'Placa do Veículo',
          'placeholder'   => 'placa do veículo',
          'class'					=> 'input-xxlarge plate'
      ));

      $this->addElement('textarea', 'info', array(
      		'label'					=> 'Informações Adicionais',
          'placeholder'   => 'informações adicionais',
          'class'					=> 'input-xxlarge',
          'rows'					=> '5'
      ));

     	$this->addElement('select','infraction', array(
      		'label'							=> 'Infração cometida',
          'class'							=> 'input-xxlarge',
      		'MultiOptions'			=> array(
      																	0 => '-- Selecione uma infração --'
      																)
  		));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar'
      ));
    }


}

