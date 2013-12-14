<?php
class Dashboard_PortfolioController extends Zend_Controller_Action {
	const thumb_width = 641;
	const thumb_height = 266;

	public function indexAction() {
		
		//$projects_db = new Default_Model_DbTable_Projects();
		//$adapter = new Zend_Paginator_Adapter_DbSelect($projects_db->select());
        //$paginator = new Zend_Paginator($adapter);
        //$paginator->setItemCountPerPage(2);
        //$paginator->setCurrentPageNumber($this->_getParam('page'));
		//$this->view->paginator = $paginator;
		

		 $this->_data = new Default_Model_DbTable_Projects();
   		 $this->view->data = $this->_data->fetchAll();
		   
	}
	
	public function addAction() {
		$form = new Dashboard_Form_Projects();
		if ($this->_request->isPost()) {
			if ($form->isValid($this->_request->getPost())) {
 				
				$projects_db = new Default_Model_DbTable_Projects();
				
				//check if project exists or not. 
				if (!$projects_db->project_exists($form->getValue('name'))) {
					$data = array(
						'name' => $form->getValue('name'),
						'category' => $form->getValue('category'),
						'description' => $form->getValue('description'),
						'complete_date' => $form->getValue('complete_date'),
						'feature1' => $form->getValue('feature1'),
						'feature2' => $form->getValue('feature2'),
						'feature3' => $form->getValue('feature3'),
						'technology1' => $form->getValue('technology1'),
						'technology2' => $form->getValue('technology2'),
						'technology3' => $form->getValue('technology3'),
						'technology4' => $form->getValue('technology4'),
						'technology5' => $form->getValue('technology5'),
						'link' => $form->getValue('link')	
					);
					$project_id = $projects_db->insert($data);


					//projects image file

					$image_db = new Default_Model_DbTable_ProjectImages();
					/*
					var_dump($_FILES);
					$uploaded_files = $this->reArrayFiles($_FILES);var_dump($uploaded_files);exit();
					$storage_path = $this->getStorage();
					foreach($uploaded_files as $file) {
						$new_name = md5($file['name'] . mktime() . rand(1, 9999));
						if (move_uploaded_file($file['tmp_file'], "{$storage_path}/{$new_name}")) {
							$data = array(
								'project_id' => $project_id,
								'file_name' => $file['name'],
								'store_name' => $new_name
							);

							//create thumbnail 
							$this->createThumbnails($new_name);
							$image_id = $image_db->insert($data);
						}
					}
					*/

					$adapter = $form->files->getTransferAdapter();
					$destination = $this->getStorage();

					if ($adapter->isUploaded()) {
						foreach ($adapter->getFileInfo() as $file => $info) {
							$new_name = md5($info['name'] . mktime() . rand(1, 9999));
							$adapter->addFilter('Rename', array('target' => "{$destination}/{$new_name}", 'overwrite' => true));
							if ($adapter->receive($info['name'])) {
								$data = array(
										'project_id' => $project_id,
										'file_name' => $info['name'],
										'store_name' => $new_name
									);
								$this->createThumbnails($new_name);
								$image_id = $image_db->insert($data);
							}
						}
					}
					
					if ($project_id) {
						$this->_redirect('/dashboard/portfolio/');
					}
				} else {
					$this->view->error = 1;
				}
			
			}
		}
		$this->view->form = $form;
	}
	
	public function deleteAction() {
		$projects_db = new Default_Model_DbTable_Projects();
		if ($this->_request->isPost()) {
			$project_id = $this->getRequest()->getPost('project_id', null);
			if (!empty($project_id)) {
				$projects_db->delete('id = ' . intval($project_id));
			}	
		}
	}
	
	public function editAction() {
		$projects_db = new Default_Model_DbTable_Projects();
		$project_id = $this->_getParam('id');
		if (!empty($project_id)) {
			$data = $projects_db->fetchRow($projects_db->select()->where('id = ?', $project_id))->toArray();	
		}
		if (empty($data)) {
			$this->_redirect('/dashboard/porfolio/');
		} 
		
		
		$form = new Dashboard_Form_Projects();
		$data['complete_date'] = !empty($data['complete_date']) ? date('Y-m-d', strtotime($data['complete_date'])) : '';
		$form->populate($data);
		
		if ($this->_request->isPost()) {
			if ($form->isValid($this->_request->getPost())) {
				
				//check if given project name existed or not. 
				if (($data['name'] == $form->getValue('name')) || !$projects_db->project_exists($form->getValue('name'))) {
					$data = array(
						'name' => $form->getValue('name'),
						'category' =>$form->getValue('category'),
						'description' => $form->getValue('description'),
						'complete_date' =>$form->getValue('complete_date'),
						'feature1' => $form->getValue('feature1'),
						'feature2' => $form->getValue('feature2'),
						'feature3' => $form->getValue('feature3'),
						'technology1' => $form->getValue('technology1'),
						'technology2' => $form->getValue('technology2'),
						'technology3' => $form->getValue('technology3'),
						'technology4' => $form->getValue('technology4'),
						'technology5' => $form->getValue('technology5'),
						'link' => $form->getValue('link')	
					);
					$projects_db->update($data, array('id=?' => $project_id));

					$image_db = new Default_Model_DbTable_ProjectImages();

					//Add images to projects.
					$adapter = $form->files->getTransferAdapter();
					$destination = $this->getStorage();
					if ($adapter->isUploaded()) {
						foreach ($adapter->getFileInfo() as $file => $info) {
							$new_name = md5($info['name'] . mktime() . rand(1, 9999));
							$adapter->addFilter('Rename', array('target' => "{$destination}/{$new_name}", 'overwrite' => true));
							if ($adapter->receive($info['name'])) {
								$data = array(
										'project_id' => $project_id,
										'file_name' => $info['name'],
										'store_name' => $new_name
									);
								$this->createThumbnails($new_name);
								$image_id = $image_db->insert($data);
							}
						}
					}	

					//delete images
					$removing_images = $form->getValue('removing_images');
					if ($removing_images != '') {
						$removing_images = explode('|', $removing_images);
						$data = $image_db->fetchAll($image_db->select()->where('image_id IN (?)', $removing_images));

						foreach ($data as $item) {
							@unlink("{$destination}/{$item->store_name}");
							$this->deleteThumbnails($item->store_name);
						}

						$image_db->delete(array('image_id IN (?)' => $removing_images));
					}

					$this->view->success = 1;
				} else {
					$this->view->error = 1;
				}
			}
		
		}
		
		//get all images of project
		$image_db = new Default_Model_DbTable_ProjectImages();
		$this->view->project_images = $image_db->fetchAll($image_db->select()->where('project_id=?', $project_id));
		
		$this->view->form = $form;
	}
	
	
	
	private function createThumbnails($filename) {
		$storage_path = $this->getStorage();
		$input_path = "{$storage_path}/{$filename}";
		$thumb_dir = "{$storage_path}/thumbs/";
		if (!is_dir($thumb_dir)) {
			mkdir($thumb_dir, 0777);
		}
		
		if(file_exists($input_path)) {
			$filter = new Polycast_Filter_ImageSize(); 
			$config = $filter->getConfig();
        
			$config->setWidth(self::thumb_width)
				   ->setHeight(self::thumb_height)
				   ->setQuality(100)
				   ->setStrategy(new Polycast_Filter_ImageSize_Strategy_Fit())
				   ->setOverwriteMode(Polycast_Filter_ImageSize::OVERWRITE_ALL);
				   //->getOutputImageType('png');
			
			$filter->setOutputPathBuilder(new Polycast_Filter_ImageSize_PathBuilder_Standard($thumb_dir));        
			$outputPath = $filter->filter($input_path);
			rename($outputPath, dirname($outputPath) . '/' . $filename);
		}
	}
	
	private function deleteThumbnails($filenames) {
		$storage_path = $this->getStorage();
		$thumb_dir = "{$storage_path}/thumbs/";
		$thumb = "{$thumb_dir}/{$filenames}";
		if (file_exists($thumb)) {
			@unlink($thumb);
		}	
	}
	
	
	private function getStorage() {
		return dirname(APPLICATION_PATH) . '/wwwroot/images/portfolio';
	}
}
?>
