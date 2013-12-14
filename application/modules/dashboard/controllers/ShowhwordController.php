<?php

class Dashboard_ShowhwordController extends Zend_Controller_Action
{
	private static $_instance_child_db = NULL;
	
	private static $_instance_smslog_db = NULL;
	
	 public function init()
    {
		$fc = Zend_Controller_Front::getInstance();
        $this->view->baseurl =  $fc->getBaseUrl();
    }
	
	private static function getChildDBInstance()
	{
		if (self::$_instance_child_db == NULL)
			self::$_instance_child_db = new Default_Model_DbTable_Child();
		
		return self::$_instance_child_db;
	}
	
	private static function getSmslogDBInstance()
	{
		if (self::$_instance_smslog_db == NULL)
			self::$_instance_smslog_db = new Default_Model_DbTable_SmsHotword();
		
		return self::$_instance_smslog_db;
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
		
        $this->view->headTitle()->prepend('SMS Log ');
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
			//$childID2 = $this->_request->getParam('id');
			$strStartDate = $this->getRequest() ->getParam('start_date', null);
			$strEndDate = $this->getRequest() ->getParam('end_date', null);
						
			$data = self::getSmslogDBInstance();//new Default_Model_DbTable_Location();
			$select = $data->select();
			$select->from($data->getName(), 
				array(
					'id',
					'userid',
					'phoneno', 
					'child_id',
					'phoneno',
					'date_time',
					'hotword_count',
					'sms_text'
				)
			);
			//SELECT * 
			//FROM rx_data
			//WHERE STR_TO_DATE(  `date_time` ,  '%M %d, %Y' ) >= STR_TO_DATE('2010-10-15', '%Y-%m-%d')
			//LIMIT 0 , 30
			$select->where('STR_TO_DATE(  `date_time` ,  \'%M %d, %Y\' ) >= STR_TO_DATE (?, \'%M %d, %Y\')', $strStartDate);
			$select->where('STR_TO_DATE(  `date_time` ,  \'%M %d, %Y\' ) <= STR_TO_DATE (?, \'%M %d, %Y\')', $strEndDate);
			$select->where('child_id =?', $childID);
			//$select->order('hotword_count');
 		
			//echo $select;
		 
			$this->view->data = $data->fetchAll($select );
	
		}
		else
		{
			$data = self::getSmslogDBInstance();//new Default_Model_DbTable_Location();
			$where = "child_id = '$childID'";
			 
			$offset = "20";
			$order = "hotword_count DESC";
			$dd = $data->fetchAll($where, $order, $offset);
			//$t = array_reverse($dd);
		 
			$this->view->data = $dd;
			//  echo $where;
			//  die();
		}
		
    }

  

}


