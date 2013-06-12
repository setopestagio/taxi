<?php

/**
 * 
 * Setup of Zend_Acl for the project. Zend_Acl give us roles and permissions of users inside the system.
 * @author andregonzaga
 *
 */
class Application_Acl_Setup
{
    /**
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * 
     * Constructor initializing Zend_Acl.
     * 
     * @access public
     * @return null
     */
    public function __construct()
    {
        $this->_acl = new Zend_Acl();
        $this->_initialize();
    }

    /**
     * 
     * Call all of rules of Zend_Acl.
     * 
     * @access protected
     * @return null
     */
    protected function _initialize()
    {
        $this->_setupRoles();
        $this->_setupResources();
        $this->_setupPrivileges();
        $this->_saveAcl();
    }

    /**
     * 
     * Setup roles of system. We have 2 types of users nowadays: guest and user.
     * 
     * @access protected
     * @return null
     */
    protected function _setupRoles()
    {
        $this->_acl->addRole( new Zend_Acl_Role('guest') );
        $this->_acl->addRole( new Zend_Acl_Role('user') );
    }

    /**
     * 
     * Load all of resources (controllers) of system. If it's created another controller
     * we should add here.
     * 
     * @access protected
     * @return null
     */
    protected function _setupResources()
    {
        $this->_acl->addResource( new Zend_Acl_Resource('auth') );
    	$this->_acl->addResource( new Zend_Acl_Resource('index') );
        $this->_acl->addResource( new Zend_Acl_Resource('dashboard') );
        $this->_acl->addResource( new Zend_Acl_Resource('doesntallow') );
        $this->_acl->addResource( new Zend_Acl_Resource('account') );
        $this->_acl->addResource( new Zend_Acl_Resource('grantee') );
        $this->_acl->addResource( new Zend_Acl_Resource('auxiliar') );
        $this->_acl->addResource( new Zend_Acl_Resource('vehicle') );
    }

    /**
     * 
     * For each action and controller we have to allow a permission of this for each
     * type of user.
     * 
     * @access protected
     * @return null
     */
    protected function _setupPrivileges()
    {
        $this->_acl	->allow( 'guest', 'index', 'index' )
        			->allow( 'guest', 'auth', array('index', 'login') );

        $this->_acl	->allow( 'user', 'index', 'index' )
        			->allow( 'user', 'auth', array('index', 'login') )
                    ->allow( 'user', 'dashboard', array('index') )
                    ->allow( 'user', 'doesntallow', array('index'))
                    ->allow( 'user', 'account', array('index', 'access', 'personal', 'photo', 'password') )
                    ->allow( 'user', 'grantee', array('index', 'new', 'edit', 'remove', 'view', 'vis', 'report',
                                                    'print-data', 'print-license') )
                    ->allow( 'user', 'auxiliar', array('index', 'new', 'edit', 'remove', 'view', 'report') )
                    ->allow( 'user', 'vehicle', array('index', 'new', 'edit', 'remove', 'view', 'vis') );
    }

    /**
     * 
     * Save configuration of Zend_Acl.
     * 
     * @access protected
     * @return null
     */
    protected function _saveAcl()
    {
        $registry = Zend_Registry::getInstance();
        $registry->set('acl', $this->_acl);
    }
}