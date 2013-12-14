<?php
class LoginController extends Zend_Controller_Action
{
    public function init()
    {
    }

	public function preDispatch()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
	}
	
	public function getAuthAdapter(array $params)
    {

    }
	
    public function indexAction()
    {
		$username 		= $this->getRequest ()->getParam ( 'username', null );
		$password		= $this->getRequest ()->getParam ( 'password', null );
		
		if ($username == null)
		{
			$this->view->bRetval = "{\"Error\":\"username is null\"}";
			return false;
		}
		
		if ($password == null)
		{
			$this->view->bRetval = "{\"Error\":\"password is null\"}";
			return false;
		}
		
		// Check if we have a POST request
        if (!$this->getRequest ()->isPost()) {
            $this->view->bRetval = "{\"Error\":\"Please use POST method to login\"}";
			return false;
        }
		
		if (false === $this->login($username, $password))
		{			
			return false;
		}
		
		$userInfo = Zend_Auth::getInstance()->getStorage()->read();
		
		$child_ids = $this->GetChildId($userInfo->member_id);
		
		$result = array();
		
		for ($i = 0; $i < count($child_ids); $i++)
		{
			$result['child_id'][] = $child_ids[$i]['id'];
			$result['child_name'][] = $child_ids[$i]['child_name'];
		}
		/*
		if (count($child_ids) > 0)
		{
			foreach ($child_ids as $childid)
			{
				$result['child_id'][] = $childid['id'];
			}
		}	
		*/	
		$result['userid'] = $userInfo->member_id;
			
		$this->view->bRetval = Zend_Json::encode($result);	
    }
	
	private function checkExistUsername($username)
	{
		$data = new Default_Model_DbTable_MemberId();
		$select = $data->select();
		$select->from($data->getName(), array('member_id', 'member_username'));
		$select->where('member_username = ?', $username);
		$rows = $data->fetchAll($select);
		
		return count($rows); 
	}
	
	private function checkExistEmail($email)
	{
		$data = new Default_Model_DbTable_MemberId();
		$select = $data->select();
		$select->from($data->getName(), array('member_id', 'member_username'));
		$select->where('member_email = ?', $email);
		$rows = $data->fetchAll($select);
		
		return count($rows);
	}
	
	private function GetChildId($userid)
	{
		$data = new Default_Model_DbTable_Child();
		$select = $data->select();
		$select->from($data->getName(), array('id', 'child_name'));
		$select->where('userid = ?', $userid);
		$rows = $data->fetchAll($select);
		
		if (!count($rows))
		{						
			return 0;
		}
		return $rows->toArray(); 
	}
	
	public function logoutAction()
	{
		$this->_auth->clearIdentity();
		$this->view->bRetval = "{\"Success\":1}";
	}
	
	public function registerAction() {
		$username 				= $this->getRequest ()->getParam('username', null);
        $member_pass 			= $this->getRequest ()->getParam('password', null);
        $member_email 			= $this->getRequest ()->getParam('email', null);
        $member_role 			= $this->getRequest ()->getParam('account_type', 2); 
		$member_city 			= $this->getRequest ()->getParam('city', '');
		$member_fullname		= $this->getRequest ()->getParam('fullname', '');
		$member_familynumbers 	= $this->getRequest ()->getParam('familymembers', 0);
		$child_id 				= $this->getRequest ()->getParam('child_id', 0);
		$number_of_child		= $this->getRequest ()->getParam('number_of_child', 0);
		$child_names = array();
		for ($i = 0; $i < $number_of_child; $i++)
		{
			$child_names[$i]	= $this->getRequest ()->getParam('childname' . $i, '');
		}
		
		if ($username == null)
		{
			$this->view->bRetval = "{\"Error\":\"username is null\"}";
			return false;
		}
		
		if ($member_pass == null)
		{
			$this->view->bRetval = "{\"Error\":\"password is null\"}";
			return false;
		}
		
		if ($member_email == null)
		{
			$this->view->bRetval = "{\"Error\":\"email is null\"}";
			return false;
		}
		
		if ($member_email == null)
		{
			$this->view->bRetval = "{\"Error\":\"email is null\"}";
			return false;
		}
		
        if ($this->_request->isPost()) 
		{
			$member = new Default_Model_DbTable_Members();               
			$data = array(
				'member_username' 		=> $username,
				'member_pass' 			=> $member_pass,
				'member_email' 			=> $member_email,
				'member_role' 			=> $member_role,
				'member_city' 			=> $member_city,
				'member_fullname' 		=> $member_fullname,
				'member_familynumbers' 	=> $member_familynumbers,
				'child_id'				=> $child_id
			);
			
			if ($this->checkExistUsername($username) > 0)
			{
				$this->view->bRetval = "{\"Error\":\"uername is already exist\"}";
				return false;
			}
			
			if ($this->checkExistEmail($member_email) > 0)
			{
				$this->view->bRetval = "{\"Error\":\"Email is already exist\"}";
				return false;
			}
			$userid = $member->insert($data);
			$child = new Default_Model_DbTable_Child();
			$re_insert  = array();
			for ($i = 0; $i < $number_of_child; $i++)
			{			
				$data_child = array (
					'userid' 			=> $userid,
					'number_of_child'	=> $number_of_child,
					'child_name'		=> $child_names[$i]
				);			
				
				$child_id = $child->insert($data_child);
				$re_insert['child_id'][] = $child_id;
			}
			$re_insert['success'] = 1; 
			$this->view->bRetval = Zend_Json::encode($re_insert);
        }
    }
	
	public function login($username, $password)
    {
		$member = new Default_Model_DbTable_Members();
		$message = $member->login($username, $password);
		if ($message !== true )
		{
            $this->view->bRetval = "{\"Error\":\"" . $message[0] . "\"}";
			return false;
        }
		
		return true;
    }
}