<?php
class TextreceivingController extends Zend_Controller_Action
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

		$phonenumber 	= $this->getRequest ()->getParam ( 'contactnumber', null );
		$datetime		= $this->getRequest ()->getParam ( 'datetime', null );
		$msg_list 		= $this->getRequest ()->getParam ( 'msg_list', null);
		$contact_name   = $this->getRequest ()->getParam ( 'contact_name', null );
		$sms_type   	= $this->getRequest ()->getParam ( 'sms_type', null );
		$msg_list		= trim($msg_list);
				
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
		
		if ($phonenumber == null)
		{
			$this->view->bRetval = 0;
			return;
		}
		
		if ($datetime == null)
		{
			$this->view->bRetval = 0;
			return;
		}
		
		$user_info = $user_info->current()->toArray();
		
		$rx_data = array('userid' => $userid, 
						'child_id' => $child_id,
						'phoneno' => $phonenumber, 
						'date_time' => $datetime,
						'contact_name' => $contact_name,
						'sms_type' =>$sms_type,
						'msg_list' => $msg_list);
		
		//$serialize = Zend_Json::encode($rx_data);
		
		$sms_id = $this->insert($rx_data);		
		
		// replace hotword by html
		$html_tag = "";
		//$msg_list = $this->replaceHotwordWithHTML($msg_list);
		
		/* update sms_hotword table */
		$dataHOT = $this->getSmsHotwordCount($msg_list, $userid, $html_tag);
		
		if ($dataHOT['count'] == 0)
		{
			$this->view->bRetval = 1;
			return;
		}
		$smsdata = new Default_Model_DbTable_SmsHotword();
			
		$sms_hotword_array = array('hotword_count' => $dataHOT['count'], 
						'sms_text' =>$dataHOT['smstext'], 
						'html_tag' => $html_tag,
						'sms_id'   => $sms_id,
						'userid' => $userid, 
						'child_id' => $child_id,
						'phoneno' => $phonenumber, 
						'contact_name' => $contact_name,
						'sms_type' =>$sms_type,
						'date_time' => $datetime );
		
		$smsdata->insert($sms_hotword_array);
		
		$this->view->bRetval = 1;
    }
	
	private function getSmsHotwordCount($smstext, $userid, $html_tag)
	{
		$retval = array();
		$data = new Default_Model_DbTable_HotwordData();
		$select = $data->select();
		$select->from($data->getName(), array('word'));
		//$select->where('userid = ?', $userid);
		$rows = $data->fetchAll($select);
		$count = 0;
		foreach ($rows as $word)
		{
			$pattern = "#(.*)(" . preg_quote(trim($word->word)) . ")(.*)#is";
			if (preg_match($pattern, $smstext))
			{
				$count++;
				$smstext = preg_replace($pattern /*"#(.*)<head>(.*?)</head>(.*)#is"*/, '$1<b>$2</b>$3', $smstext);
			}	
		}
		$retval['count'] = $count;
		$retval['smstext'] = $smstext;
		
		return $retval;
	}
	
	private function replaceHotwordWithHTML($smstext)
	{
		return $smstext;
	}
	
	private function insert($rx_data)
	{
		//$insertdata = array('userid' => $userid, 'text_serialize' => $serialize);	
								
		$data = new Default_Model_DbTable_RxData();
		return $data->insert($rx_data);
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