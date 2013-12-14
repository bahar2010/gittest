<?php
class ImagetrackingController extends Zend_Controller_Action
{
    public function init()
    {
    }

	public function preDispatch()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
	}
	
    public function indexAction()
    {
		$child_id		= $this->getRequest ()->getParam ( 'childid', null );
		$userid 		= $this->getRequest ()->getParam ( 'userid', null );
		//$listImages 	= $this->getRequest ()->getParam ( 'image_list', null );
		$datetime		= $this->getRequest ()->getParam ( 'datetime', '' );
		//$listImages = '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';
		//$datetime = 'Jul 5, 2012 12:00:50 PM';
		
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
			$this->view->bRetval = "userid is not exist";
			return;
		}
		
		//$user_info = $user_info->current()->toArray();
		{
			$image = $_FILES['image_file']['name'];
			if ($image == '')
			{
				$this->view->bRetval = "File is not seted";
				return;
			}
			$image_filename = $this->GetImageFullFile($userid, $child_id) . '_' . $image;
			//$user_info = $user_info->current()->toArray();
			move_uploaded_file($_FILES['image_file']['tmp_name'], $image_filename);
		}
		
		$rx_data = array(	
							'userid' => $userid, 
							'child_id' => $child_id,
							'image_file' => $image_filename, 
							'date_time' => $datetime
						);
		
		//$serialize = Zend_Json::encode($rx_data);
		$this->insert($rx_data);
		
		$this->view->bRetval = 1;
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
	
	private function GetImageFullFile($userid, $child_id)
	{
		$audio_dirname_userid = APPLICATION_PATH . "/../data/images/" . $userid . "/";
		$this->mkdirIfNotExists($audio_dirname_userid);
		$image_dirname = $audio_dirname_userid . $child_id;
		$image_filename = $image_dirname . "/". time();		
		
		$this->mkdirIfNotExists($image_dirname);
		return $image_filename;
	}
	
	private function mkdirIfNotExists($dir)
	{
		if(file_exists($dir) && is_dir($dir))
			return;
		
		if(!mkdir($dir))
		{
			return false;	
		}
	}
	
	private function insert($insertdata)
	{
		//$insertdata = array('userid' => $userid, 'text_serialize' => $serialize);									
		$data = new Default_Model_DbTable_ImagetrackingData();
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