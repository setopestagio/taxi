<?php

class Application_Form_City extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->addElement('text', 'name', array(
      		'label'					=> 'Cidade',
          'placeholder'   => 'nome da cidade',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar'
      ));
    }


}

