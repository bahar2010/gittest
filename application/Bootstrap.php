<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initNavigation() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $configs = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $container = new Zend_Navigation($configs);
        $role = 'guest';
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $role = $this->roleFromInt($auth->getIdentity()->member_role);
        }
        $view->navigation($container)->setAcl(Zend_Registry::get('acl'))->setRole($role);
    }

    protected function _initViewHelpers() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $view->headTitle()->append('HireRemote');
        $view->headTitle()->setSeparator(' - ');
    }

    //protected function _initStatesList()
    //{
        //if (!Zend_Registry::isRegistered('states')) {
           // $dataFile = 'data/us-states.xml';
           // $states = array();
           // $data = simplexml_load_file($dataFile);

           // foreach ($data->item as $item) {
             //   $states[(string) $item->value] = (string) $item->label;
           // }
            
           // Zend_Registry::set('states', $states);
       // }
   // }

    
    public static function roleFromInt($role) {
        switch ($role) {
            case 1: return 'admin';
            case 2: return 'member';
            case 3: return 'member';
            case 4: return 'member';
            default: return 'guest';
        }
    }

}