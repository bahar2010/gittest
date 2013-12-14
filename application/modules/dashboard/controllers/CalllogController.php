<?php

class Dashboard_CalllogController extends Zend_Controller_Action
{
	
	private static $_instance_child_db = NULL;
	
	private static $_instance_calllog_db = NULL;
	
	private $_countchild;
	
    public function init()
    {
		$fc = Zend_Controller_Front::getInstance();
        $this->view->baseurl =  $fc->getBaseUrl();
		$this->_countchild = 0;
    }
	
	private static function getChildDBInstance()
	{
		if (self::$_instance_child_db == NULL)
			self::$_instance_child_db = new Default_Model_DbTable_Child();
		
		return self::$_instance_child_db;
	}
	
	private static function getCalllogDBInstance()
	{
		if (self::$_instance_calllog_db == NULL)
			self::$_instance_calllog_db = new Default_Model_DbTable_Calllog();
		
		return self::$_instance_calllog_db;
	}

	public function preDispatch()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
        //$this->_helper->layout->disableLayout();
	}
	
    public function indexAction()
    {
		$childID = $this->_request->getParam('id');
		
		$this->view->childid = $this->_request->getParam('id');
		
		$this->view->childName = $this->_request->getParam('name');
		
        $this->view->headTitle()->prepend('Call Log ');
        $id = Zend_Auth::getInstance()->getIdentity()->member_id;
		
		$datachildname = self::getChildDBInstance();//new Default_Model_DbTable_Child();
		$where = "id = '$childID'";
		
		$this->view->datachildname = $datachildname->fetchAll($where);
		
		$datachild = self::getChildDBInstance();//new Default_Model_DbTable_Child();
        $where = "id = '$childID'";
      //  echo $where;
      //  die();
	 	
        
        $this->view->datachild = $datachild->fetchAll($where);
		
		

		$datachild2 = self::getChildDBInstance();//new Default_Model_DbTable_Child();
        $where = "userid = '$id'";
      //  echo $where;
      //  die();
        
        $this->view->datachild2 = $datachild2->fetchAll($where);
		
		if ($this->getRequest () ->isPost())
		{	
		
			$childID2 = $this->_request->getParam('id');
			$strStartDate = $this->getRequest() ->getParam('start_date', null);
			$strEndDate = $this->getRequest() ->getParam('end_date', null);
			
			$startdate 	=  date('Y-m-d H:m:s', strtotime($strStartDate));//2012-08-07 06:33:58
			$enddate 	=  date('Y-m-d H:m:s', strtotime($strEndDate));//2012-08-07 06:33:58
			
			$data = self::getCalllogDBInstance();//new Default_Model_DbTable_Location();
			$select = $data->select();
			$select->from('call_tracking_data', 
				array(
					'id',
					'date_time',
					'phoneno', 
					'call_type'
				)
			);
			$select->where('date_time >= ?', $startdate);
			$select->where('date_time <= ?', $enddate);
			$select->where('child_id =?', $childID);
 		
			
		 
			$this->view->data = $data->fetchAll($select );
	
		}
		else
		{
			$data = self::getCalllogDBInstance();//new Default_Model_DbTable_Location();
			$where = "child_id = '$childID'";
			$offset = "20";
		$order = "id DESC";
		 $dd = $data->fetchAll($where, $order, $offset)->toArray();
		 $t = array_reverse($dd);
		 
			
		$this->view->data = $t;
			//  echo $where;
			//  die();
		}
    }

}