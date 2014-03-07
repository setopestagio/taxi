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
        $this->_acl->addResource( new Zend_Acl_Resource('administration') );
        $this->_acl->addResource( new Zend_Acl_Resource('inspection') );
        $this->_acl->addResource( new Zend_Acl_Resource('survey') );
        $this->_acl->addResource( new Zend_Acl_Resource('assessment') );
        $this->_acl->addResource( new Zend_Acl_Resource('clandestine') );
        $this->_acl->addResource( new Zend_Acl_Resource('scheduling') );
        $this->_acl->addResource( new Zend_Acl_Resource('agendamento') );
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
        			->allow( 'guest', 'auth', array('index', 'login') )
                    ->allow( 'guest', 'scheduling', array(  'schedule','return-all-events', 'return-hour', 'return-events',
                                                            'remove', 'reschedule') )
                    ->allow( 'guest', 'agendamento', array( 'index', 'completo', 'confirmacao', 'documentos', 'print-confirmation',
                                                            'consulta') );

        $this->_acl	->allow( 'user', 'index', 'index' )
        			->allow( 'user', 'auth', array('index', 'login') )
                    ->allow( 'user', 'administration', array(   'index', 'inspector', 'inspector-new', 'inspector-edit',
                                                                'user', 'user-new', 'user-edit',
                                                                'city', 'city-new', 'city-edit',
                                                                'model-vehicle', 'model-vehicle-new', 'model-vehicle-edit',
                                                                'brand-vehicle', 'brand-vehicle-new', 'brand-vehicle-edit',
                                                                'model-taximeter', 'model-taximeter-new', 'model-taximeter-edit',
                                                                'brand-taximeter', 'brand-taximeter-new', 'brand-taximeter-edit') )
                    ->allow( 'user', 'inspection', array('index', 'new', 'edit', 'view', 'remove') )
                    ->allow( 'user', 'clandestine', array('index', 'new', 'edit', 'view', 'remove') )
                    ->allow( 'user', 'dashboard', array('index') )
                    ->allow( 'user', 'doesntallow', array('index'))
                    ->allow( 'user', 'account', array('index', 'access', 'personal', 'photo', 'password') )
                    ->allow( 'user', 'grantee', array('index', 'new', 'edit', 'remove', 'view', 'vis', 'report',
                                                    'print-data', 'print-license', 'report-grantee-all', 'report-grantee-actives',
                                                    'return-people', 'extract-pendencies', 'save-auxiliar', 'remove-auxiliar',
                                                    'reservation', 'reservation-license', 'exclude-auxiliar', 'print-communication',
                                                    'edit-auxiliar', 'report-vehicle','report-vehicle-age', 'new-historic', 'edit-historic', 'remove-historic',
                                                    'add-auxiliar-historic', 'edit-auxiliar-historic', 'remove-auxiliar-historic',
                                                    'edit-permission') )
                    ->allow( 'user', 'auxiliar', array('index', 'new', 'edit', 'remove', 'view', 'report',
                                                    'print-license', 'print-data', 'save-grantee', 'return-grantee', 'remove-grantee',
                                                    'report-auxiliar-all', 'report-auxiliar-active-all', 'report-grantee-auxiliar-active-all') )
                    ->allow( 'user', 'vehicle', array('index', 'new', 'edit', 'remove', 'view', 'vis') )
                    ->allow( 'user', 'survey', array('index', 'calendar') )
                    ->allow( 'user', 'assessment', array('index', 'new', 'edit', 'view', 'remove', 'report') )
                    ->allow( 'user', 'scheduling', array('index', 'treatment', 'calendar', 'return-events', 'return-all-events', 
                                                    'return-hour', 'return-schedulings', 'hour', 'report', 'delete-hour', 'graphic',
                                                    'return-schedulings-vis', 'report-scheduling', 'remove', 'reschedule') )
                    ->allow( 'user', 'agendamento', array(  'index', 'completo', 'confirmacao', 'documentos', 'print-confirmation',
                                                            'consulta') );
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