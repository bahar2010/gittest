<?php

final class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    protected $_acl;
    protected $_errorPage;

    public function __construct() {

        $this->_errorPage = array(
            'module' => 'default',
            'controller' => 'error',
            'action' => 'denied'
        );

        $this->_initAcl();
        Zend_Registry::set('acl', $this->_acl);
    }

    private function _initAcl() {

        $this->_acl = new Zend_Acl();

        //Roles
        $this->_acl->addRole(new Zend_Acl_Role('guest'))
                ->addRole(new Zend_Acl_Role('member'), 'guest')
                ->addRole(new Zend_Acl_Role('admin'), 'member')
                ->addRole(new Zend_Acl_Role('full'), 'admin');

        //Resources
        $this->_acl->add(new Zend_Acl_Resource('index'))
                ->add(new Zend_Acl_Resource('find'))
                ->add(new Zend_Acl_Resource('hunt'))
                ->add(new Zend_Acl_Resource('discover'))
                ->add(new Zend_Acl_Resource('restfull'))
                ->add(new Zend_Acl_Resource('login'))
                ->add(new Zend_Acl_Resource('portfolio'))
                ->add(new Zend_Acl_Resource('contact'))
                ->add(new Zend_Acl_Resource('faqs'))
                ->add(new Zend_Acl_Resource('register'))
                ->add(new Zend_Acl_Resource('newsletter'))
                ->add(new Zend_Acl_Resource('marketing'))
				->add(new Zend_Acl_Resource('our'))
                ->add(new Zend_Acl_Resource('process'))
                ->add(new Zend_Acl_Resource('user'))
                ->add(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('error'))
                ->add(new Zend_Acl_Resource('signupcomplete'))
                ->add(new Zend_Acl_Resource('dashboard:advance'))
                ->add(new Zend_Acl_Resource('change-password'))
                ->add(new Zend_Acl_Resource('dashboard:index'))
                ->add(new Zend_Acl_Resource('dashboard:news'))
                ->add(new Zend_Acl_Resource('dashboard:portfolio'))
                ->add(new Zend_Acl_Resource('dashboard:pages'))
                ->add(new Zend_Acl_Resource('dashboard:domains'))
                ->add(new Zend_Acl_Resource('dashboard:faqs'))
                ->add(new Zend_Acl_Resource('dashboard:newscategories'))
                ->add(new Zend_Acl_Resource('admin:index'))
                ->add(new Zend_Acl_Resource('admin:news'));

        //Deny Guest
        $this->_acl->deny('guest', 'user')
                ->deny('guest', 'admin');

        //Allow Guest
        $this->_acl->allow('guest', 'index', array('index', 'orderdomain', 'domaincheck', 'payment'))
                ->allow('guest', 'user', array('login', 'register', 'index'))
                ->allow('guest', 'register', array('index', 'domain-name', 'orderdomain', 'payment'))
                ->allow('guest', 'error')
                ->allow('guest', 'hunt')
                ->allow('guest', 'discover')
                ->allow('guest', 'portfolio')
                ->allow('guest', 'newsletter')
                ->allow('guest', 'login')
                ->allow('guest', 'faqs', array('index',
                    'web-hosting',
                    'web-design',
                    'online-marketing',
                    'domain-names'))
                ->allow('guest', 'find', array('index',
                    'job'
                ))
                ->allow('guest', 'hunt', array('index',
                    'worker'))
                ->allow('guest', 'contact', array('index',
                    'seo',
                    'done'))
				 ->allow('guest', 'our', array('privacypolicy',
					'terms'))				
                ->allow('guest', 'process', array('index', 'process'))
                ->allow('guest', 'dashboard:portfolio')
                ->allow('guest', 'dashboard:domains')
                ->allow('guest', 'dashboard:faqs')
                ->allow('guest', 'dashboard:pages');
        //Deny Member
        $this->_acl->deny('member', 'user', array('login', 'register'));

        //Allow Member	
        $this->_acl->allow('member', 'dashboard:index')
                ->allow('member', 'user', array('logout', 'profile', 'change-password'));
        //->allow('member', 'dashboard:portfolio');
        //Deny Admin
        //Allow Admin
        $this->_acl->allow('admin', 'admin:index')
                ->allow('admin', 'dashboard:news')
                ->allow('admin', 'dashboard:newscategories')
                ->allow('admin', 'admin:news');
    }

    private function denyAccess() {
        $this->_request->setModuleName($this->_errorPage['module']);
        $this->_request->setControllerName($this->_errorPage['controller']);
        $this->_request->setActionName($this->_errorPage['action']);
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $auth = Zend_Auth::getInstance();
        $role = 'guest';

        if ($auth->hasIdentity()) {
            $role = $this->roleFromInt($auth->getIdentity()->member_role);
        }

        $resourceName = '';
        $module = $this->_request->getModuleName();
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();

        if ($module !== 'default') {
            $resourceName = $module . ':';
        }

        $resourceName .= $controller;

        if (!$this->getAcl()->isAllowed($role, $resourceName, $action)) {
            $this->denyAccess();
        }
    }

    public function getAcl() {
        return $this->_acl;
    }

    public function getErrorPage() {
        return $this->_errorPage;
    }

    public function setErrorPage($module, $controller, $action) {
        $this->_errorPage = array(
            'module' => $module,
            'controller' => $controller,
            'action' => $action
        );
    }

    public static function roleFromInt($role) {
        switch ($role) {
            case 1: return 'admin';
            case 2: return 'member';
            case 3: return 'member';
            case 4: return 'member';
            case 5: return 'full';
            default: return 'guest';
        }
    }

}
