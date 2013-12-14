<?php

class Dashboard_PagesController extends Zend_Controller_Action
{	
	const thumb_height = 400;
	const thumb_width = 350;
	 
	
	public function indexAction()
    {
	$this->view->headTitle()->prepend('Your Homepage Editing section ');
					
    }
	
	public function homepageAction() 
	
	{
		$this->view->headTitle()->prepend('Your Homepage Editing section ');
		
		$sliders = new Dashboard_Model_DbTable_Sliders();
        $this->view->sliders = $sliders->fetchAll();
		
		$domains = new Dashboard_Model_DbTable_Domains();
		$this->view->domains = $domains->fetchAll();
		
		$hostings = new Dashboard_Model_DbTable_Hostings();
		$this->view->hostings = $hostings->fetchAll();
		
		$homepageprojects = new Dashboard_Model_DbTable_Homepageprojects();
		$this->view->homepageprojects = $homepageprojects->fetchAll();
		
		$homepageservices = new Dashboard_Model_DbTable_Homepageservices();
		$this->view->homepageservices = $homepageservices->fetchAll();
	}
	
	public function addsliderAction()
	
	{
		$form = new Dashboard_Form_Slider();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) {
					$text1 = $form->getValue('text1');
					$text2 = $form->getValue('text2');
					$text3 = $form->getValue('text3');
					$text4 = $form->getValue('text4');
					$homepage_link = $form->getValue('homepage_link');
					$file = $form->getValue('file');
				
					$sliders = new Dashboard_Model_DbTable_Sliders();
					$adapter = $form->files->getTransferAdapter();
					$destination = $this->getStorage();
					$destination1 = 'http://new.winwinhost.com/wwwroot/images/sliders/home_page_1/';

					if ($adapter->isUploaded()) {
						foreach ($adapter->getFileInfo() as $file => $info) {
							//$new_name = md5($info['name'] . mktime() . rand(1, 9999));
							$adapter->addFilter('Rename', array('target' => "{$destination}/{$info['name']}", 'overwrite' => true));
							if ($adapter->receive($info['name'])) {
								$data = array(
											'slider_id' => $slider_id,
											'homepage_slider_text1' => $text1,
											'homepage_slider_text2' => $text2,
											'homepage_slider_text3' => $text3,
											'homepage_slider_text4' => $text4,
											'homepage_link' => $homepage_link,
											'imagepath' => $destination1.$info['name'],
										);
								//$this->slider_wh($new_name);
								$slider_id = $sliders->insert($data);
							}
						}
					}			
					
					$this->_helper->redirector('homepage');
				} 
				else {
					$form->populate($formData);
				}
		}		
    }
	
	
	
	public function editsliderAction()
	
	{
	$form = new Dashboard_Form_Slider();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $slider_id = (int)$form->getValue('slider_id');
                $text1 = $form->getValue('text1');
                $text2 = $form->getValue('text2');
				$text3 = $form->getValue('text3');
				$text4 = $form->getValue('text4');
				$homepage_link = $form->getValue('homepage_link');
                $file = $form->getValue('file');
				
					$sliders = new Dashboard_Model_DbTable_Sliders();
					$adapter = $form->files->getTransferAdapter();
					$destination = $this->getStorage();

					if ($adapter->isUploaded()) {
						foreach ($adapter->getFileInfo() as $file => $info) {
							//$new_name = md5($info['name'] . mktime() . rand(1, 9999));
							$adapter->addFilter('Rename', array('target' => "{$destination}/{$info['name']}", 'overwrite' => true));
							if ($adapter->receive($info['name'])) {
								
								/*$data = array(
											'homepage_slider_text1' => $text1,
											'homepage_slider_text2' => $text2,
											'homepage_slider_text3' => $text3,
											'homepage_slider_text4' => $text4,
											'imagepath' => $destination.$info['name'],
										);
								//$this->slider_wh($new_name);
								$slider_id = $sliders->update($data, 'slider_id = ' .(int)$id);*/
								$imagepath = 'http://new.winwinhost.com/wwwroot/images/sliders/home_page_1/'.$info['name'];
								$sliders->updateSlider($slider_id, $text1, $text2, $text3, $text4, $homepage_link, $imagepath);
								
							}
						}
					}			
				                
                $this->_helper->redirector('homepage');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
			
            if ($id > 0) {
                $sliders = new Dashboard_Model_DbTable_Sliders();
                $form->populate($sliders->getSlider($id));
            }
        }
			
	}
	
	public function deletesliderAction()
	
	{
	if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') { 
				$id = $this->getRequest()->getPost('id');
				$sliders = new Dashboard_Model_DbTable_Sliders();
				$sliders->deleteSlider($id);
			}	
			$this->_helper->redirector('homepage');
		} 		
 
		else {
			$id = $this->_getParam('id', 0);
			$slider = new Dashboard_Model_DbTable_Sliders();
			$this->view->slider = $slider->getSlider($id);
		} 
	
	
	}
	
	public function adddomainAction()
	
	{
		$form = new Dashboard_Form_Domain();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) {
					$Extension = $form->getValue('Extension');
					$Dollars = $form->getValue('Dollars');
					$Cents = $form->getValue('Cents');
							
					
					$domain = new Dashboard_Model_DbTable_Domains();
					$domain->addDomain($domain_id, $Extension, $Dollars, $Cents);
					$this->_helper->redirector('homepage');
				}
				else {
					$form->populate($formData);
				}
	
		}
	}
	
	public function editdomainAction()
	
	{
	
		$form = new Dashboard_Form_Domain();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $domain_id = (int)$form->getValue('domain_id');
                $Extension = $form->getValue('Extension');
                $Dollars = $form->getValue('Dollars');
				$Cents = $form->getValue('Cents');
                $domains = new Dashboard_Model_DbTable_Domains();
                $domains->updateDomain($domain_id, $Extension, $Dollars, $Cents);
                
                $this->_helper->redirector('homepage');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
			
            if ($id > 0) {
                $domains = new Dashboard_Model_DbTable_Domains();
                $form->populate($domains->getDomain($id));
            }
        }
	
	}
	
	public function deletedomainAction()
	{
		
	if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') { 
				$id = $this->getRequest()->getPost('id');
				$domains = new Dashboard_Model_DbTable_Domains();
				$domains->deleteDomain($id);
			}	
			$this->_helper->redirector('homepage');
		} 		
 
		else {
			$id = $this->_getParam('id', 0);
			$domain = new Dashboard_Model_DbTable_Domains();
			$this->view->domain = $domain->getDomain($id);
		} 
	
	}
	
	public function addhostingAction()
	
	{
		$form = new Dashboard_Form_Hosting();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) {
					$homepage_hosting_type = $form->getValue('homepage_hosting_type');
					$starting_price_dollars = $form->getValue('starting_price_dollars');
					$starting_price_cents = $form->getValue('starting_price_cents');
					$hosting_link = $form->getValue('hosting_link');
					$hosting_class = $form->getValue('hosting_class');		
					
					$hosting = new Dashboard_Model_DbTable_Hostings();
					$hosting->addHosting($hosting_id, $homepage_hosting_type, $starting_price_dollars, $starting_price_cents, $hosting_link, $hosting_class);
					$this->_helper->redirector('homepage');
				}
				else {
					$form->populate($formData);
				}
	
		}
				
	}
	
	public function edithostingAction()
	
	{
	
	$form = new Dashboard_Form_Hosting();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $hosting_id = (int)$form->getValue('hosting_id');
                $homepage_hosting_type = $form->getValue('homepage_hosting_type');
                $starting_price_dollars = $form->getValue('starting_price_dollars');
				$starting_price_cents = $form->getValue('starting_price_cents');
				$hosting_link = $form->getValue('hosting_link');
				$hosting_class = $form->getValue('hosting_class');
                $hostings = new Dashboard_Model_DbTable_Hostings();
                $hostings->updateHosting($hosting_id, $homepage_hosting_type, $starting_price_dollars, $starting_price_cents, $hosting_link, $hosting_class);
                
                $this->_helper->redirector('homepage');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
			
            if ($id > 0) {
                $hostings = new Dashboard_Model_DbTable_Hostings();
                $form->populate($hostings->getHosting($id));
            }
        }
	
	}
	
	public function deletehostingAction()
	
	{
	
	if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') { 
				$id = $this->getRequest()->getPost('id');
				$hostings = new Dashboard_Model_DbTable_Hostings();
				$hostings->deleteHosting($id);
			}	
			$this->_helper->redirector('homepage');
		} 		
 
		else {
			$id = $this->_getParam('id', 0);
			$hosting = new Dashboard_Model_DbTable_Hostings();
			$this->view->hosting = $hosting->getHosting($id);
		} 
	
	}
	
	public function addhomepageprojectAction()
	
	{
	
	$form = new Dashboard_Form_Homepageproject();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) {
					$project_title = $form->getValue('project_title');
					$project_summary = $form->getValue('project_summary');
					$project_link = $form->getValue('project_link');
					$file = $form->getValue('file');
				
					$homepageprojects = new Dashboard_Model_DbTable_Homepageprojects();
					$adapter = $form->files->getTransferAdapter();
					$destination_t = $this->getprojectStoraget();
					$destination_l = $this->getprojectStoragel();
					$destination1 = 'http://new.winwinhost.com/wwwroot/images/projectPhotos/';
					$destination2 = 'http://new.winwinhost.com/wwwroot/images/projectPhotos/large/';

					if ($adapter->isUploaded()) {
						$iteration = 1;
						foreach ($adapter->getFileInfo() as $file => $info) {
							//$new_name = md5($info['name'] . mktime() . rand(1, 9999));
							if($iteration == 1){
								$adapter->addFilter('Rename', array('target' => "{$destination_t}/{$info['name']}", 'overwrite' => true));
							}
							else{
								$adapter->addFilter('Rename', array('target' => "{$destination_l}/{$info['name']}", 'overwrite' => true));
							}		
							if ($adapter->receive($info['name'])) {
								if($iteration == 1){
									$project_imgpath_thumb = $destination1.$info['name'];
								}
								else{
									$project_imgpath_large = $destination2.$info['name'];
								}			
							}
							$iteration = $iteration+1;
						}
						$project_imgpath_large = $destination2.$info['name'];
						$data = array(
											'homepageproject_id' => $homepageproject_id,
											'project_imgpath_thumb' => $project_imgpath_thumb,
											'project_imgpath_large' => $project_imgpath_large,
											'project_title' => $project_title,
											'project_summary' => $project_summary,
											'project_link' => $project_link,
											
										);
								//$this->slider_wh($new_name);
								$homepageproject_id = $homepageprojects->insert($data);
						
					}			
					
					$this->_helper->redirector('homepage');
				} 
				else {
					$form->populate($formData);
				}
		}		
	
		
		
	}
	
	public function edithomepageprojectAction()
	{
	
	$form = new Dashboard_Form_Homepageproject();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) {
					$homepageproject_id = $form->getValue('homepageproject_id');
					$project_title = $form->getValue('project_title');
					$project_summary = $form->getValue('project_summary');
					$project_link = $form->getValue('project_link');
					$file = $form->getValue('file');
				
					$homepageprojects = new Dashboard_Model_DbTable_Homepageprojects();
					$adapter = $form->files->getTransferAdapter();
					$destination_t = $this->getprojectStoraget();
					$destination_l = $this->getprojectStoragel();
					$destination1 = 'http://new.winwinhost.com/wwwroot/images/projectPhotos/';
					$destination2 = 'http://new.winwinhost.com/wwwroot/images/projectPhotos/large/';

					if ($adapter->isUploaded()) {
						$iteration = 1;
						foreach ($adapter->getFileInfo() as $file => $info) {
							//$new_name = md5($info['name'] . mktime() . rand(1, 9999));
							if($iteration == 1){
								$adapter->addFilter('Rename', array('target' => "{$destination_t}/{$info['name']}", 'overwrite' => true));
							}
							else{
								$adapter->addFilter('Rename', array('target' => "{$destination_l}/{$info['name']}", 'overwrite' => true));
							}		
							if ($adapter->receive($info['name'])) {
								if($iteration == 1){
									$project_imgpath_thumb = $destination1.$info['name'];
								}
								else{
									$project_imgpath_large = $destination2.$info['name'];
								}			
							}
							$iteration = $iteration+1;
						}
						$project_imgpath_large = $destination2.$info['name'];
						$data = array(
											'homepageproject_id' => $homepageproject_id,
											'project_imgpath_thumb' => $project_imgpath_thumb,
											'project_imgpath_large' => $project_imgpath_large,
											'project_title' => $project_title,
											'project_summary' => $project_summary,
											'project_link' => $project_link,
											
										);
								//$this->slider_wh($new_name);
						$homepageprojects->updateHomepageproject($homepageproject_id, $project_imgpath_thumb, $project_imgpath_large, $project_title, $project_summary, $project_link);
						
					}			
					//$homepageprojects->updateHomepageproject($homepageproject_id, $project_imgpath_thumb, $project_imgpath_large, $project_title, $project_summary, $project_link);
					$this->_helper->redirector('homepage');
				} 
				else {
					$form->populate($formData);
				}
        } else {
            $id = $this->_getParam('id', 0);
			
            if ($id > 0) {
                $homepageprojects = new Dashboard_Model_DbTable_Homepageprojects();
                $form->populate($homepageprojects->getHomepageproject($id));
            }
        }
	
	}
	
	public function deletehomepageprojectAction()
	
	{
	
	if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') { 
				$id = $this->getRequest()->getPost('id');
				$homepageprojects = new Dashboard_Model_DbTable_Homepageprojects();
				$homepageprojects->deleteHomepageproject($id);
			}	
			$this->_helper->redirector('homepage');
		} 		
 
		else {
			$id = $this->_getParam('id', 0);
			$homepageproject = new Dashboard_Model_DbTable_Homepageprojects();
			$this->view->homepageproject = $homepageproject->getHomepageproject($id);
		} 
	
	}
	
	public function addhomepageserviceAction()
	
	{
	$form = new Dashboard_Form_Homepageservice();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) {
					$services_title = $form->getValue('services_title');
					$services_title_tag = $form->getValue('services_title_tag');
					$services_summary = $form->getValue('services_summary');
					$service_link = $form->getValue('service_link');
					$services_class = $form->getValue('services_class');
					$file = $form->getValue('file');
				
					$homepageservices = new Dashboard_Model_DbTable_Homepageservices();
					
					$data = array(
											'services_id' => $services_id,
											'services_title' => $services_title,
											'services_title_tag' => $services_title_tag,
											'services_summary' => $services_summary,
											'service_link' => $service_link,
											'services_class' => $services_class,											
										);		
					$services_id = $homepageservices->insert($data);
					$this->_helper->redirector('homepage');
				} 
				else {
					$form->populate($formData);
				}
		}		
		
	
	}
	
	public function edithomepageserviceAction()
	
	{
	
	$form = new Dashboard_Form_Homepageservice();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $services_id = (int)$form->getValue('services_id');
                $services_title = $form->getValue('services_title');
                $services_title_tag = $form->getValue('services_title_tag');
				$services_summary = $form->getValue('services_summary');
				$service_link = $form->getValue('service_link');
				$services_class = $form->getValue('services_class');
				$file = $form->getValue('file');
				
				$homepageservices = new Dashboard_Model_DbTable_Homepageservices();
						
				$homepageservices->updateHomepageservice($services_id, $services_title, $services_title_tag, $services_summary, $service_link, $services_class);                
                $this->_helper->redirector('homepage');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
			
            if ($id > 0) {
                $homepageservices = new Dashboard_Model_DbTable_Homepageservices();
                $form->populate($homepageservices->getHomepageservice($id));
            }
        }
	
	}
	
	public function deletehomepageserviceAction()
	
	{
	
	if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') { 
				$id = $this->getRequest()->getPost('id');
				$homepageservices = new Dashboard_Model_DbTable_Homepageservices();
				$homepageservices->deleteHomepageservice($id);
			}	
			$this->_helper->redirector('homepage');
		} 		
 
		else {
			$id = $this->_getParam('id', 0);
			$homepageservice = new Dashboard_Model_DbTable_Homepageservices();
			$this->view->homepageservice = $homepageservice->getHomepageservice($id);
		} 
	
	}
	
	
	
	
	private function slider_wh($filename) {
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
		return dirname(APPLICATION_PATH).'/wwwroot/images/sliders/home_page_1/';
	}
	
	private function getprojectStoraget() {
		return dirname(APPLICATION_PATH).'/wwwroot/images/projectPhotos/';
	}
	
	private function getprojectStoragel() {
		return dirname(APPLICATION_PATH).'/wwwroot/images/projectPhotos/large';
	}
	
	private function getserviceStorage() {
		return dirname(APPLICATION_PATH).'/wwwroot/images/services';
	}
	
}	

?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

