<?php

class Dashboard_LocationController extends Zend_Controller_Action
{
	private static $_instance_child_db = NULL;
	
	private static $_instance_location_db = NULL;
	
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
	
	private static function getLocationDBInstance()
	{
		if (self::$_instance_location_db == NULL)
			self::$_instance_location_db = new Default_Model_DbTable_Location();
		
		return self::$_instance_location_db;
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
		
        $this->view->headTitle()->prepend('Latest Location  ');
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
			$strStartDate = $this->getRequest() ->getParam('start_date', null);
			$strEndDate = $this->getRequest() ->getParam('end_date', null);
			
			$startdate 	=  date('Y-m-d H:m:s', strtotime($strStartDate));//2012-08-07 06:33:58
			$enddate 	=  date('Y-m-d H:m:s', strtotime($strEndDate));//2012-08-07 06:33:58
			
			$data = self::getLocationDBInstance();//new Default_Model_DbTable_Location();
			$select = $data->select();
			$select->from('members_location', 
				array(
					'members_location_id',
					'member_location_timestamp',
					'members_location_member_id',
					'members_location_lati', 
					'members_location_longi'
				)
			);
			$select->where('member_location_timestamp >= ?', $startdate);
			$select->where('member_location_timestamp <= ?', $enddate);
			
			$this->view->data = $data->fetchAll($select);
	
		}
		else
		{
			$data = self::getLocationDBInstance();//new Default_Model_DbTable_Location();
			$where = "members_location_child_id = '$childID'";
			$this->view->data = $data->fetchAll($where);
			//  echo $where;
			//  die();
		}
    }
	

}


