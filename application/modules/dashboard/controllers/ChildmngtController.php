<?php
class Dashboard_ChildmngtController extends Zend_Controller_Action
{
	private static $_instance_child_db = NULL;
	
	private $_countchild;
	
    public function init()
    {
		$fc = Zend_Controller_Front::getInstance();
        $this->view->baseurl =  $fc->getBaseUrl();
		$this->_countchild = 0;
    }
	
	private static function getInstance()
	{
		if (self::$_instance_child_db == NULL)
			self::$_instance_child_db = new Default_Model_DbTable_Child();
		
		return self::$_instance_child_db;
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
		$childinfo = $this->GetAllChildInfo($id);
		/*echo "<pre>";
		print_r($childinfo);
		echo "</pre>";*/
		
		$this->_countchild = count($childinfo);
		//Zend_Registry::set('countchild', count($childinfo));
		$this->view->data = $childinfo;
	}
	
	private function getCountChild()
	{
		return $this->_countchild;
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
		
		$numberchild = count($this->GetAllChildInfo($userid));
		
		// Update for all number of child
		self::getInstance()->update(array('number_of_child' => $numberchild));
		
		$this->_redirect("/dashboard/childmngt");
	}
	
	public function addAction()
	{
		if ($this->getRequest () ->isPost())
		{
			$userid = Zend_Auth::getInstance()->getIdentity()->member_id;
			$childname = $this->getRequest ()->getParam ( 'childname', null );
			
			if ($childname == null)
			{
				echo "Invalid child name";
				return;
			}
			
			$numberchild = count($this->GetAllChildInfo($userid)) + 1;
			
			$data = array('child_name' => $childname, 'userid' => $userid, 'number_of_child' => $numberchild);
			
			self::getInstance()->insert($data);
			
			// Update for all number of child
			self::getInstance()->update(array('number_of_child' => $numberchild));
			
			$this->_redirect("/dashboard/childmngt");
		}	
	}
	
	public function editAction()
	{		
		if ($this->getRequest()->isPost())
		{
			$userid = Zend_Auth::getInstance()->getIdentity()->member_id;
			$childid 	= $this->getRequest ()->getParam ( 'childid', null );
			$childname 	= $this->getRequest ()->getParam ('childname', null );
			$countChild = count($this->GetAllChildInfo($userid));
			echo $countChild;
			$data = array('child_name' => $childname, 'number_of_child' => $countChild);
			$where['id = ?'] = $childid;
			self::getInstance()->update($data, $where);
			
			// Update for all number of child
			self::getInstance()->update(array('number_of_child' => $countChild));
			
			$this->_redirect("/dashboard/childmngt");
		} 
		else
		{
			$id = $this->getRequest ()->getParam ( 'id', null );
			if ($id == null)
			{
				echo "Invalid id";
				return;
			}
			$this->view->data = $this->GetChildInfo($id);
		}
	}
	
	private function GetAllChildInfo($userid)
	{
		$data = self::getInstance();
		$select = $data->select();
		$select->from($data->getName(), array('id', 'child_name', 'userid', 'number_of_child'));
		$select->where('userid = ?', $userid);
		$rows = $data->fetchAll($select);
		
		return $rows->toArray(); 
	}
	
	private function GetChildInfo($childid)
	{
		$data = self::getInstance();
		$select = $data->select();
		$select->from($data->getName(), array('id', 'child_name', 'userid', 'number_of_child'));
		$select->where('id = ?', $childid);
		$rows = $data->fetchAll($select);
		
		if (!count($rows))
		{						
			return 0;
		}
		return $rows->current()->toArray(); 
	}
}