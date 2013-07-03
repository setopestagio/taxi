<?php

class Application_Form_User extends Twitter_Bootstrap_Form_Horizontal
{

    public function init()
    {
      $this->setIsArray(true);

      $this->addElement('text', 'name', array(
      		'label'					=> 'Nome',
          'placeholder'   => 'nome completo',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('text', 'phone', array(
      		'label'					=> 'Telefone',
          'placeholder'   => 'telefone',
          'class'					=> 'input-xlarge phone'
      ));

      $this->addElement('text', 'email', array(
      		'label'					=> 'E-mail',
          'placeholder'   => 'email',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('text', 'username', array(
      		'label'					=> 'Usuário no sistema',
          'placeholder'   => 'usuário para logar no sistema',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('password', 'password', array(
      		'label'					=> 'Senha',
          'placeholder'   => 'senha',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('password', 'confirm_password', array(
      		'label'					=> 'Confirme a senha',
          'placeholder'   => 'confirme a senha',
          'class'					=> 'input-xlarge'
      ));

      $this->addElement('submit', 'submit', array(
        'buttonType' 			=> Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
        'label'      			=> 'Salvar'
      ));
    }


}

