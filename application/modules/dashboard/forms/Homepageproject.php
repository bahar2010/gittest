<?php

class Dashboard_Form_Homepageproject extends Zend_Form
{
    public function init()
    {
        $this->setName('homepageproject');
        $homepageproject_id = new Zend_Form_Element_Hidden('homepageproject_id');
        $homepageproject_id->addFilter('Int');
		
		$project_title = new Zend_Form_Element_Text('project_title');
        $project_title->setLabel('project_title')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
		$project_summary = new Zend_Form_Element_Text('project_summary');
        $project_summary->setLabel('project_summary')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			

		$project_link = new Zend_Form_Element_Text('project_link');
        $project_link->setLabel('project_link')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
		$project_images = new Zend_Form_Element_File('files');
		$project_images->setLabel('Select Thumb and Large Images for this Project')
				->setIsArray(true)
				->setValueDisabled(true)
				->setAttrib('class', 'multi')
				->setMultiFile(2)
				->setAttrib('accept', 'gif|jpg|png')
				->setAttrib('maxlength', 6)
				->setRequired(false)
				->addValidator(new Zend_Validate_File_IsImage);
				
		
	
			
		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($homepageproject_id, $project_title, $project_summary, $project_link, $project_images, $submit));
		
		}
}

?>