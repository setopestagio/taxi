<?php

class Application_Form_Reservation extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->setAction('/grantee/reservation')
            ->setMethod('post');

      $this->addElement('text', 'start_date', array(
      		'label'					=> 'Data de Início',
          'placeholder'   => 'data de início',
          'class'					=> 'input-xlarge datepicker dateMask'
      ));

      $this->addElement('text', 'end_date', array(
      		'label'					=> 'Data de Fim',
          'placeholder'   => 'data de fim',
          'class'					=> 'input-xlarge datepicker dateMask'
      ));

      $this->addElement('text', 'plate_date', array(
      		'label'					=> 'Data de Emplacamento',
          'placeholder'   => 'data de emplacamento',
          'class'					=> 'input-xlarge datepicker dateMask'
      ));

      $this->addElement('text', 'period', array(
      		'label'					=> 'Período',
          'placeholder'   => 'período de reserva',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('textarea', 'reason', array(
      		'label'					=> 'Motivo',
          'placeholder'   => 'motivo',
          'class'					=> 'input-xlarge',
          'rows'					=> '5'
      ));

      $this->addElement('textarea', 'info', array(
      		'label'					=> 'Informações Adicionais',
          'placeholder'   => 'informações adicionais',
          'class'					=> 'input-xlarge',
          'rows'					=> '5'
      ));

      $this->addElement('hidden', 'grantee');
      $this->addElement('hidden', 'id');

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar'
      ));
    }


}

