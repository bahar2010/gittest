<?php

class Dashboard_BrowsinghistoryController extends Zend_Controller_Action
{
	
	private static $_instance_child_db = NULL;
	
	private static $_instance_browsinghistory_db = NULL;
	
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
	
	private static function getBrowsinghistoryDBInstance()
	{
		if (self::$_instance_browsinghistory_db == NULL)
			self::$_instance_browsinghistory_db = new Default_Model_DbTable_BrowsehistorytrackingData();
		
		return self::$_instance_browsinghistory_db;
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
		
        $this->view->headTitle()->prepend('Browsing History ');
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
			
			//$startdate 	=  date('Y-m-d H:m:s', strtotime($strStartDate));//2012-08-07 06:33:58
			//$enddate 	=  date('Y-m-d H:m:s', strtotime($strEndDate));//2012-08-07 06:33:58
			
			$data = self::getBrowsinghistoryDBInstance(); 
			$select = $data->select();
			$select->from('browsehistory_tracking_data', 
				array(
					'id',
					'child_id',
					'date_time',
					'title', 
					'url'
				)
			);
			//$select->where('url >= ?', $startdate);
			//$select->where('url <= ?', $enddate);
			$select->where('STR_TO_DATE(  `url` ,  \'%M %d, %Y\' ) >= STR_TO_DATE (?, \'%M %d, %Y\')', $strStartDate);
			$select->where('STR_TO_DATE(  `url` ,  \'%M %d, %Y\' ) <= STR_TO_DATE (?, \'%M %d, %Y\')', $strEndDate);
			//$select->where('child_id =?', $childID);
			//echo $select;
			
		 
			$this->view->data = $data->fetchAll($select );
	
		}
		else
		{
			$data = self::getBrowsinghistoryDBInstance(); 
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