<?php
class Dashboard_Form_Projects extends Zend_Form {
	 public function init()
    {
        $this->setMethod('post');
		$this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
		//$view = $this->getView();
		//$url = $view->url(array('module' => 'dashboard', 'controller' => 'portfolio', 'action' => 'add'));
		//$this->setAction($url);
		

        $project_name = new Zend_Form_Element_Text('name');
        $project_name->setLabel('Name')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');

		$options = array(
			'Web site' => 'Web site', 
			'Web app' => 'Web app' , 
			'mobile app' => 'mobile', 
			'web design' => 'web design', 
			'marketing' => 'marketing', 
			'seo' => 'seo'
		);
		$category = new Zend_Form_Element_Select('category');
        $category->setLabel('Category')
                ->addMultiOptions($options);
		
		$complete_date = new Zend_Form_Element_text('complete_date');
	    $complete_date->setLabel('Date of project done (yyyy-mm-dd)')
			->setAttrib('class', 'form-date')	
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('date','yyyy-mm-dd');
  
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description');
		$project_images = new Zend_Form_Element_File('files');
		$project_images->setLabel('Select Images for this project')
				->setIsArray(true)
				->setAttrib('class', 'multi')
				->setAttrib('accept', 'gif|jpg|png')
				->setAttrib('maxlength', 6)
				->setRequired(false)
				->addValidator(new Zend_Validate_File_IsImage);
				//->addValidator(new Zend_Validate_File_Size('2MB'))
				//->setDestination(dirname(APPLICATION_PATH) . '/wwwroot/images/pofolio');
	
		
		

/*
        $recaptchaKeys = new Zend_config_Xml(APPLICATION_PATH . '/configs/recaptchaKeys.xml');
		$recaptcha = new Zend_Service_ReCaptcha($recaptchaKeys->publicKey, $recaptchaKeys->privateKey);
		$captcha = new Zend_Form_Element_Captcha('captcha',
			array(
				'captcha'       => 'ReCaptcha',
				'captchaOptions' => array('captcha' => 'ReCaptcha', 'service' => $recaptcha),
				'ignore' => true
				)
		);
 */	
		
		//project page
		$link = new Zend_Form_Element_text('link');
		$link->setLabel("project page's link")
			->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');

	
		//feature fields.
		$feature1 = new Zend_Form_Element_Text('feature1');
        $feature1->setLabel('Feature 1')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		$feature2 = new Zend_Form_Element_Text('feature2');
        $feature2->setLabel('Feature 2')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		$feature3 = new Zend_Form_Element_Text('feature3');
        $feature3->setLabel('Feature 3')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		//technology
		$technology1 = new Zend_Form_Element_Text('technology1');
        $technology1->setLabel('Techonology 1')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');

		$technology2 = new Zend_Form_Element_Text('technology2');
        $technology2->setLabel('Techonology 2')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');

		$technology3 = new Zend_Form_Element_Text('technology3');
        $technology3->setLabel('Techonology 3')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		$technology4 = new Zend_Form_Element_Text('technology4');
        $technology4->setLabel('Techonology 4')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		$technology5 = new Zend_Form_Element_Text('technology5');
        $technology5->setLabel('Techonology 5')
        	->setRequired(false)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		
		$removing_images = new Zend_Form_Element_Hidden('removing_images');
		$removing_images->setAttrib('id', 'removing_images')
						->setRequired(false);
		
        $submit = new Zend_Form_Element_Submit('submit', 'Submit');
        
        $this->addElements(array(
            $project_name,
			$category,
			$complete_date,
            $description,
			$link,
			$feature1,
			$feature2,
			$feature3,
			$technology1,
			$technology2,
			$technology3,
			$technology4,
			$technology5,
			$project_images,
			$removing_images,
			//$captcha,
            $submit
        ));
       
    }

}

?>
