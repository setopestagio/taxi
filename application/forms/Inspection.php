<?php

class Application_Form_Inspection extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
     	$this->setIsArray(true);

      $this->addElement('text', 'local', array(
      		'label'					=> 'Local',
          'placeholder'   => 'local da fiscalização',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('text', 'inspection_date', array(
      		'label'					=> 'Data',
          'placeholder'   => 'data da fiscalização realizada',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('text', 'plate', array(
      		'label'					=> 'Placa do Veículo',
          'placeholder'   => 'placa do veículo',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('textarea', 'info', array(
      		'label'					=> 'Informações Adicionais',
          'placeholder'   => 'informações adicionais',
          'class'					=> 'input-xlarge',
          'rows'					=> '5'
      ));

     	$this->addElement('select','infraction', array(
      		'label'							=> 'Infração cometida',
          'class'							=> 'input-xlarge',
      		'MultiOptions'			=> array(
      																	0 => '-- Selecione uma infração --',
      																	1 => 'Aberto', 
      																	2 => 'Processado',
      																	3	=> 'Andamento',
      																	4 => 'Concluído',
      																	5	=> 'Aguardando pagamento',
      																	6	=> 'Pagamento realizado'
      																)
  		));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar'
      ));
    }


}

