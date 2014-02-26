<?php

class Application_Form_SchedulingHour extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->addElement('text', 'hour', array(
      		'label'					=> 'Horário',
          'placeholder'   => 'horário',
          'class'					=> 'form-control hourMask'
      ));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar',
        'class'           => 'col-lg-offset-5'
      ));
    }


}

