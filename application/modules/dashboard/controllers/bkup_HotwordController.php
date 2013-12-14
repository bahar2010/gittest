<?php
class Dashboard_HotwordController extends Zend_Controller_Action
{
	private static $_instance_hotword_db = NULL;
	
    public function init()
    {
		$fc = Zend_Controller_Front::getInstance();
        $this->view->baseurl =  $fc->getBaseUrl();
    }
	
	private static function getInstance()
	{
		if (self::$_instance_hotword_db == NULL)
			self::$_instance_hotword_db = new Default_Model_DbTable_HotwordData();
		
		return self::$_instance_hotword_db;
	}

	public function preDispatch()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
        //$this->_helper->layout->disableLayout();
	}
	
	public function indexAction()
	{
		$this->view->headTitle()->prepend('Your Dashboard ');
        $id = Zend_Auth::getInstance()->getIdentity()->member_id;
		$hotwordinfo = $this->GetAllHotwordInfo($id);
		
		$this->view->data = $hotwordinfo;
	}
		
	public function deleteAction()
	{
		$this->view->headTitle()->prepend('Your Dashboard ');
        $userid = Zend_Auth::getInstance()->getIdentity()->member_id;
		$id = $this->getRequest ()->getParam ( 'id', null );
		if ($id == null)
		{
			echo "Invalid id";
			return;
		}
		
		$where = "id = $id"; 		
		
		self::getInstance()->delete($where);
		
		$this->_redirect("/dashboard/hotword");
	}
	
	public function addAction()
	{
		if ($this->getRequest () ->isPost())
		{
			$userid = Zend_Auth::getInstance()->getIdentity()->member_id;
			$hotword = $this->getRequest ()->getParam ( 'hotword', null );
			$priority = $this->getRequest ()->getParam ( 'priority', null );
			if ($hotword == null)
			{
				echo "Invalid child name";
				return;
			}			
			$hotwords = explode(",", $hotword);
			foreach ($hotwords as $word)
			{
				$data = array(
						'word' => $word, 
						'userid' => $userid, 
						'module' => 'smslog', 
						'priority' => $priority
					);
				try 
				{
					self::getInstance()->insert($data);
				}
				catch(Zend_Db_Exception $e)
				{
					
				}	
			}
			$this->_redirect("/dashboard/hotword");
		}	
	}
	
	public function editAction()
	{		
		if ($this->getRequest()->isPost())
		{
			$userid = Zend_Auth::getInstance()->getIdentity()->member_id;
			$hotwordid 	= $this->getRequest ()->getParam ( 'hotwordid', null );
			$priority 	= $this->getRequest ()->getParam ( 'priority', null );
			$hotword 	= $this->getRequest ()->getParam ( 'hotword', null );
				
			$data = array('word' => $hotword, 'priority' => $priority);
			$where['id = ?'] = $hotwordid;
			self::getInstance()->update($data, $where);
			
			$this->_redirect("/dashboard/hotword");
		} 
		else
		{
			$id = $this->getRequest ()->getParam ( 'id', null );
			if ($id == null)
			{
				echo "Invalid id";
				return;
			}
			$this->view->data = $this->GetHotwordInfo($id);
		}
	}
	
	private function GetAllHotwordInfo($userid)
	{
		$data = self::getInstance();
		$select = $data->select();
		$select->from($data->getName(), array('id', 'module', 'userid', 'priority', 'word'));
		$select->where('userid = ?', $userid);
		$rows = $data->fetchAll($select);
		
		return $rows->toArray(); 
	}
	
	private function GetHotwordInfo($hotwordid)
	{
		$data = self::getInstance();
		$select = $data->select();
		$select->from($data->getName(), array('id', 'priority', 'module', 'word'));
		$select->where('id = ?', $hotwordid);
		$rows = $data->fetchAll($select);
		
		if (!count($rows))
		{						
			return 0;
		}
		return $rows->current()->toArray(); 
	}
}