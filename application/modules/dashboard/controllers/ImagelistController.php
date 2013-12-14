<?php

class Dashboard_ImagelistController extends Zend_Controller_Action
{
	
	
    public function indexAction()
    {
		$childID = $this->_request->getParam('id');
		
		$this->view->childid = $this->_request->getParam('id');
		
		$this->view->childName = $this->_request->getParam('name');
		
        $this->view->headTitle()->prepend('Imagelistt');
        $id = Zend_Auth::getInstance()->getIdentity()->member_id;
         
        $data = new Default_Model_DbTable_Imagelist();
        $where = "child_id = '$childID'";
      //  echo $where;
      //  die();
        
        $this->view->data = $data->fetchAll($where);
		
		
		
		
		
		
		$datachildname = new Default_Model_DbTable_Child();
		$where = "id = '$childID'";
		
		$this->view->datachildname = $datachildname->fetchAll($where);
		
		
		
		
		
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


