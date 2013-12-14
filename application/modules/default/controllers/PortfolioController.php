<?php

class PortfolioController extends Zend_Controller_Action
{

    public function init()
    {
    }
 

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Portfolio WinWinHost');
		$image_db = new Default_Model_DbTable_ProjectImages();
		$this->view->data = $image_db->fetchAll();
		
		$select = $image_db->select()->from(array('I' => 'project_images'), array('I.image_id', 'I.file_name', 'I.store_name'))
				->joinInner(array('P' => 'projects'), 'P.id = I.project_id', array('P.id' ,'P.name', 'P.category', 'P.feature1', 'P.feature2', 'P.feature3', 'P.link', 'if (LENGTH(P.description) > 150,  CONCAT(SUBSTRING(P.description, 1, 150), " ..."), P.description) as description'))
				->group('P.id')
				->order(array('P.id DESC'));
		
		$select->setIntegrityCheck(false);
		$adapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
		$this->view->data = $paginator;		
    }
		
	public function detailsAction() {
		$this->view->headTitle()->prepend('Portfolio WinWinHost');	
		/*$projectId = $this->_getParam('projectid');	
		if (!empty($projectId)) {
			$project_db = new Default_Model_DbTable_Projects();
			$select = $project_db->select()
					->from($project_db, array('id', 'name', 'category', 'DATE(complete_date) AS complete_date', 'description'))
					->where('id=?', $projectId);
			$project_info = $project_db->fetchRow($select);		
		}*/
		
		$projectname = $this->_getParam('projectname');	
		if (!empty($projectname)) {
			$project_db = new Default_Model_DbTable_Projects();
			
			$columns = array('id', 'name', 'category', 'link',
				'feature1', 'feature2', 'feature3', 
				'technology1', 'technology2', 'technology3', 'technology4', 'technology5',
				'DATE(complete_date) AS complete_date', 'description'
			);
			$select = $project_db->select()
					->from($project_db, $columns)
					->where('name=?', $projectname);
			$project_info = $project_db->fetchRow($select);		
		}
		
		
		if ($project_info) {
			$image_db = new Default_Model_DbTable_ProjectImages();
			$this->view->project_info = $project_info;
			$this->view->project_images = $image_db->fetchAll($image_db->select()->where('project_id=?', $project_info->id));
		} else {
			$this->_redirect('/portfolio/index/');
		}
	}
	
}