<?php

class Dashboard_IndexController extends Zend_Controller_Action
{
    
	
	public function indexAction()
    {
       $Identity = Zend_Auth::getInstance()->getIdentity()->member_id;
          
                 $db = Zend_Db::factory('Pdo_Mysql', array(
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'winwinhost'
            ));
         
          



     
   }


	 public function truckersindexAction()
    {
        
    }
	
	 public function loadersindexAction()
    {
        
    }

    public function myTrucksAction()
    {
        $dbTable = new Dashboard_Model_NewTrucks();
        
        $select = $dbTable->select()->where('owner = ?', Zend_Auth::getInstance()->getIdentity()->member_id->member_role);
        $this->view->data = $dbTable->fetchAll($select)->toArray();
    }

    public function myLoadsAction()
    {

    }
}





