<?php
class AudiotrackingController extends Zend_Controller_Action
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
		//$this->getRequest ()->getParam ( 'audio', null );
		$datetime		= $this->getRequest ()->getParam ( 'datetime', null );
		$audio_name		= $this->getRequest ()->getParam ( 'audio_name', null );
		
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
			$audio = $_FILES['audio']['name'];
			$audio_filename = $this->GetAudioFullFile($userid, $child_id) . '_' . $audio;
			$user_info = $user_info->current()->toArray();
			move_uploaded_file($_FILES['audio']['tmp_name'], $audio_filename);
		}
		
		$rx_data = array(	
							'userid' => $userid, 
							'child_id' => $child_id,
							'audio' => $audio_filename, 
							'date_time' => $datetime,
							'audio_name' => $audio_name
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
		
		$upload->setDestination($audio_finename);

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
	
	private function GetAudioFullFile($userid, $childid)
	{
		$audio_dirname_userid = APPLICATION_PATH . "/../data/audios/" . $userid . "/";
		$this->mkdirIfNotExists($audio_dirname_userid);
		$audio_dirname = $audio_dirname_userid . $childid;
		$audio_finename = $audio_dirname . "/" . time();
		
		$this->mkdirIfNotExists($audio_dirname);
		return $audio_finename;
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
		$data = new Default_Model_DbTable_AudiotrackingData();
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