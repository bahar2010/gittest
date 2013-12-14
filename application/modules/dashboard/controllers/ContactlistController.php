<?php
class Dashboard_ContactlistController extends Zend_Controller_Action
{
    public function init()
    {
    }

	public function preDispatch()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
        //$this->_helper->layout->disableLayout();
	}
	
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
	
	public function showAction()
	{
		$data = new Default_Model_DbTable_ContactlistData();
		$select = $data->select();
		$select->from($data->getName(), array('*'));
		//$select->limit(0, 100);
		$rows = $data->fetchAll($select);
		var_dump($rows);
		$this->view->contactlist = $rows;
    }
	
    public function indexAction()
    {
		$child_id		= $this->getRequest ()->getParam ( 'childid', null );
		//$userid 		= $this->getRequest ()->getParam ( 'userid', null );
		
		$datetime		= $this->getRequest ()->getParam ( 'datetime', null );
		$phoneno		= $this->getRequest ()->getParam ( 'phoneno', null );
		$call_type		= $this->getRequest ()->getParam ( 'call_type', null );
		
		if ($child_id == null)
		{
			$this->view->bRetval = "child is null";
			return;
		}
		
		$userid_child = $this->GetUserIDbyChildId($child_id);
		$userid = $userid_child['userid'];
		
		//$datetime = 'Jul 5, 2012 12:00:50 PM';
		if ($userid == null)
		{
			$this->view->bRetval = "userid is null";
			return;
		}
		$user_info = $this->checkUserId($userid);
		
		if (!count($user_info))
		{			
			$this->view->bRetval = "userid is not exist";
			return;
		}
		
		if ($phoneno == null)
		{
			$this->view->bRetval = "phoneno is null";
			return;
		}
		
		if ($call_type == null)
		{
			$this->view->bRetval = "call_type is null";
			return;
		}
		
		$rx_data = array(	
							'userid' => $userid, 
							'child_id' => $child_id,
							'phoneno' => $phoneno, 
							'date_time' => $datetime,
							'call_type' => $call_type
						);
						
		$this->insert($rx_data);
		
		$this->view->bRetval = 1;
    }
	
	private function insert($insertdata)
	{
		$data = new Default_Model_DbTable_CalltrackingData();
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