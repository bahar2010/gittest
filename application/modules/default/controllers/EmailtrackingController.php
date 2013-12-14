<?php
class EmailtrackingController extends Zend_Controller_Action
{
    public function init()
    {
    }

	public function preDispatch()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
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
	
    public function indexAction()
    {
		$child_id		= $this->getRequest ()->getParam ( 'childid', null );
		//$userid 		= $this->getRequest ()->getParam ( 'userid', null );
		$datetime		= $this->getRequest ()->getParam ( 'datetime', null );
		$email_address 	= $this->getRequest ()->getParam ( 'email_address', null );
		$contact_name   = $this->getRequest ()->getParam ( 'contact_name', null );
		
		if ($child_id == null)
		{
			$this->view->bRetval = "child is null";
			return;
		}
		
		$userid_child = $this->GetUserIDbyChildId($child_id);
		$userid = $userid_child['userid'];
		
		if ($userid == null)
		{
			$this->view->bRetval = "userid is null";
			return;
		}

		$user_info = $this->checkUserId($userid);
		
		if (!count($user_info))
		{
			$this->view->bRetval = "userid doesnt exist";
			return;
		}
		
		$user_info = $user_info->current()->toArray();
		
		$rx_data = array('userid' => $userid, 
						'child_id' => $child_id,
						'date_time' => $datetime, 
						'contact_name' => $contact_name,
						'email_address' => $email_address);
		
		//$serialize = Zend_Json::encode($rx_data);
		
		$this->insert($rx_data);
		
		$this->view->bRetval = 1;
    }
	
	private function insert($rx_data)
	{
		//$insertdata = array('userid' => $userid, 'text_serialize' => $serialize);	
								
		$data = new Default_Model_DbTable_EmailaddressData();
		$data->insert($rx_data);
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