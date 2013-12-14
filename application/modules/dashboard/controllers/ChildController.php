<?php

class Dashboard_ChildController extends Zend_Controller_Action
{
	
	
    public function indexAction()
    {
		$this->view->headTitle()->prepend('Your Family Members ');
        $id = Zend_Auth::getInstance()->getIdentity()->member_id;
		
		
		
		
		$childID = $this->_request->getParam('id');
		
		$this->view->childid = $this->_request->getParam('id');
		
		$this->view->childName = $this->_request->getParam('name');
		
		
		
        
         

		$datachild = new Default_Model_DbTable_Child();
        $where = "id = '$childID'";
      //  echo $where;
      //  die();
        
        $this->view->datachild = $datachild->fetchAll($where);
		
		
		
		
		$datachild2 = new Default_Model_DbTable_Child();
        $where = "userid = '$id'";
      //  echo $where;
      //  die();
        
        $this->view->datachild2 = $datachild2->fetchAll($where);
		

		
		
    }
	

	
	
	
	public function init()
    {
    }

   

}


