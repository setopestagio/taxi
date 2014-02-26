<?php

class Application_Form_VehicleModel extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->addElement('text', 'name', array(
      		'label'					=> 'Modelo',
          'placeholder'   => 'modelo de automóvel',
          'class'					=> 'form-control'
      ));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar',
        'class'           => 'col-lg-offset-5'
      ));
    }


}

