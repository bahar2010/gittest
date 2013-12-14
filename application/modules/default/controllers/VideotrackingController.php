<?php
class VideotrackingController extends Zend_Controller_Action
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
		//$this->getRequest ()->getParam ( 'video', null );
		$datetime		= $this->getRequest ()->getParam ( 'datetime', null );
		$video_name		= $this->getRequest ()->getParam ( 'video_file', null );
		
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
			$this->view->bRetval = 0;
			return;
		}
		$user_info = $this->checkUserId($userid);
		
		if (!count($user_info))
		{			
			$this->view->bRetval = 0;
			return;
		}
		
		//if ()
		{
			$video = $_FILES['video_file']['name'];
			if ($video == '')
			{
				$this->view->bRetval = "File is not seted";
				return;
			}
			$video_filename = $this->GetVideoFullFile($userid, $child_id) . '_' . $video;
			$user_info = $user_info->current()->toArray();
			move_uploaded_file($_FILES['video_file']['tmp_name'], $video_filename);
		}
		
		$rx_data = array(	
							'userid' => $userid,
							'child_id' => $child_id,	
							'video_filename' => $video_filename, 
							'date_time' => $datetime
						);
		
		/*$upload = new Zend_File_Transfer_Adapter_Http();
		$upload->addValidator('Count', false, array('min' =>1, 'max' => 1))
			   ->addValidator('IsImage', false, 'jpeg')
			   ->addValidator('Size', false, array('max' => '512kB'))
			   ->setDestination('/tmp');

		if (!$upload->isValid()) 
		{
			throw new Exception('Bad image data: '.implode(',', $upload->getMessages()));
		}
		
		$upload->setDestination($video_finename);

		try {
				$upload->receive();
		} 
		catch (Zend_File_Transfer_Exception $e) 
		{
				throw new Exception('Bad image data: '.$e->getMessage());
		}*/
		
		//$serialize = Zend_Json::encode($rx_data);
		$this->insert($rx_data);
		
		$this->view->bRetval = 1;
    }
	
	private function GetVideoFullFile($userid, $childid)
	{
		$audio_dirname_userid = APPLICATION_PATH . "/../data/videos/" . $userid . "/";
		$this->mkdirIfNotExists($audio_dirname_userid);
		$video_dirname = $audio_dirname_userid . $childid;
		$video_finename = $video_dirname . "/" . time();
		
		$this->mkdirIfNotExists($video_dirname);
		return $video_finename;
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
		$data = new Default_Model_DbTable_VideotrackingData();
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