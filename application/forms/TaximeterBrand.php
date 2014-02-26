<?php

class Application_Form_TaximeterBrand extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->addElement('text', 'name', array(
      		'label'					=> 'Marca',
          'placeholder'   => 'marca de taxímetro',
          'class'					=> 'form-control'
      ));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar',
        'class'           => 'col-lg-offset-5'
      ));
    }


}

