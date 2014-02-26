<?php

class Application_Form_Inspection extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
     	$this->setIsArray(true);

      $this->addElement('text', 'local', array(
      		'label'					=> 'Local',
          'placeholder'   => 'local da fiscalização',
          'class'					=> 'form-control'
      ));

      $this->addElement('text', 'inspection_date', array(
      		'label'					=> 'Data',
          'placeholder'   => 'data da fiscalização realizada',
          'class'					=> 'form-control dateMask'
      ));

      $this->addElement('text', 'permission', array(
          'label'         => 'Permissionário',
          'placeholder'   => 'número da permissão',
          'class'         => 'form-control permission'
      ));

      $this->addElement('text', 'plate', array(
      		'label'					=> 'Placa do Veículo',
          'placeholder'   => 'placa do veículo',
          'class'					=> 'form-control plate'
      ));

      $this->addElement('textarea', 'info', array(
      		'label'					=> 'Informações Adicionais',
          'placeholder'   => 'informações adicionais',
          'class'					=> 'form-control',
          'rows'					=> '5'
      ));

     	$this->addElement('select','infraction', array(
      		'label'							=> 'Infração cometida',
          'class'							=> 'form-control',
      		'MultiOptions'			=> array(
      																	0 => '-- Selecione uma infração --'
      																)
  		));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar',
        'class'           => 'col-lg-offset-5'
      ));
    }


}

