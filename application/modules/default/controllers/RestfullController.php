<?php
class RestfullController extends Zend_Controller_Action
{
    public function init()
    {
    }
/*
	public function __construct()
	{
		
	}
	
	public function __destruct()
	{
	
	}
*/
	
	private function GetUserIDbyChildId($childid)
	{
		$data = new Default_Model_DbTable_Child();
		$select = $data->select();
		$select->from($data->getName(), array('id', 'userid'));
		$select->where('id = ?', $childid);
		$select->group('userid');
		$rows = $data->fetchAll($select);
		
		if (!count($rows))
		{						
			return 0;
		}
		return $rows->current()->toArray(); 
	}
	
    public function mainAction()
    {
		$child_id		= $this->getRequest ()->getParam ( 'childid', null );
		//$userid 		= $this->getRequest ()->getParam ( 'userid', null );
		$longitude 	= $this->getRequest ()->getParam ( 'longitude', null );
		$latitude	= $this->getRequest ()->getParam ( 'latitude', null );
		$datetime   = $this->getRequest ()->getParam ( 'datetime', null );
		
		//$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
		
		if ($longitude == null)
		{
			$this->view->bRetval = 0;
			return;
		}
		
		if ($latitude == null)
		{
			$this->view->bRetval = 0;
			return;
		}
		
		if ($child_id == null)
		{
			$this->view->bRetval = "child is null";
			return;
		}
		
		$userid_child = $this->GetUserIDbyChildId($child_id);
		$userid = $userid_child['userid'];
		
		if ($userid == null)
		{
			$this->view->bRetval = 0;
			return;
		}

		$user_info = $this->checkUserId($userid);
		
		if (!count($user_info))
		{
			$this->view->bRetval = 0;
			return;
		}
		$user_info = $user_info->current()->toArray();
		$user_info['member_username'];
		//$long_lat = $this->getRestfullData($userid);
		/*
		echo "<pre>";
		print_r($long_lat);
		echo "</pre>";
		*/
		//$this->insert($user_info, $long_lat['longitude'], $long_lat['latitude']);
		$this->insert($user_info, $longitude, $latitude, $datetime, $child_id);
		
		$this->view->bRetval = 1;
    }
	
	private function getRestfullData($userid)
	{
		$data = new Default_Model_DbTable_Restfull();
		$select = $data->select();
		$select->from($data->getName(), array('userid', 'longitude', 'latitude'));
		$select->where('userid = ?', $userid);
		$rows = $data->fetchAll($select);
		
		return $rows->current()->toArray();
	}
	
	private function insert($user_info, $longitude, $latitude, $datetime, $childid)
	{
		$data = new Default_Model_DbTable_MemberLocation();
		//$date_expr = new Zend_Db_Expr($data->getAdapter()->quoteInto("STR_TO_DATE(?, '%M %d, %Y %r:%i%p')", $datetime));
		
		$insertdata = array('members_location_member_id' 	=> $user_info['member_id'], 
								'members_location_username' => $user_info['member_username'],
								'members_location_longi' 	=> $longitude, 
								'members_location_lati' 	=> $latitude,
								'members_location_child_id' => $childid,
								'member_location_timestamp'	=> $datetime);//$date_expr);
		
			
		$data->insert($insertdata);
	}
	
    private function checkUserId($userid)
	{
		$data = new Default_Model_DbTable_MemberId();
		$select = $data->select();
		$select->from($data->getName(), array('member_id', 'member_username'));
		$select->where('member_id = ?', $userid);
		$rows = $data->fetchAll($select);

		return $rows; 
	}
}