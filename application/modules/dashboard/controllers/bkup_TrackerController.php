<?php

class Dashboard_TrackerController extends Zend_Controller_Action
{
	
	public function init()
    {
    }
	
      public function indexAction()
    {
        
		
		$childID = $this->_request->getParam('id');
		
		$this->view->childid = $this->_request->getParam('id');
		$this->view->childName = $this->_request->getParam('name');
		
		$this->view->headTitle()->prepend('Movement Track');
        $id = Zend_Auth::getInstance()->getIdentity()->member_id;
        $data = new Default_Model_DbTable_Location();
		$where = "members_location_member_id = '$childID'";
  
		//$offset = "3";
		//$order = "members_location_id DESC";
		$this->view->data = $data->fetchAll($where);

		//$datasymbol = new Default_Model_DbTable_Location();
		//$where = "members_location_member_id = '$id'";
		//$this->view->datasymbol  = $datasymbol ->fetchAll($where, $order);

		//$datasymbol2 = new Default_Model_DbTable_Location();
		//$where = "members_location_member_id = '$id'";
		//$this->view->datasymbol2 = $datasymbol2->fetchAll($where);
		
		
		
        $id = Zend_Auth::getInstance()->getIdentity()->member_id;
        $data = new Default_Model_DbTable_Location();
		$where = "members_location_child_id = '$childID'";
  
		$offset = "50";
		$order = "members_location_id DESC";
		 $dd = $data->fetchAll($where, $order, $offset)->toArray();
		 $t = array_reverse($dd);
		 
			
		$this->view->data = $t;
		
		
		
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
 
   	

   

}
