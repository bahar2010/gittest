<?php

class Dashboard_Form_Homepageservice extends Zend_Form
{
    public function init()
    {
        $this->setName('homepageservice');
        $services_id = new Zend_Form_Element_Hidden('services_id');
        $services_id->addFilter('Int');
		
        $services_title = new Zend_Form_Element_Text('services_title');
        $services_title->setLabel('Service Title')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
        $services_title_tag = new Zend_Form_Element_Text('services_title_tag');
        $services_title_tag->setLabel('Service Title Tag')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
				
		$services_summary = new Zend_Form_Element_Text('services_summary');
        $services_summary->setLabel('Service Summary')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
				
		$service_link = new Zend_Form_Element_Text('service_link');
        $service_link->setLabel('Service Link')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
				
		$services_class = new Zend_Form_Element_Select('services_class');
		$services_class->setLabel('Service_Class:')
				->addMultiOptions(array(
				'Design' => 'Design',
				'Support' => 'Support',
				'Easy' => 'Easy',
				'Fonts' => 'Fonts'
				
		));		
				
					
		/*$services_imgpath = new Zend_Form_Element_File('files');
		$services_imgpath->setLabel('Select Image for this Service')
				->setIsArray(true)
				->setAttrib('class', 'multi')
				->setAttrib('accept', 'gif|jpg|png')
				->setAttrib('maxlength', 6)
				->setRequired(false)
				->addValidator(new Zend_Validate_File_IsImage);*/

			

		
		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($services_id, $services_title, $services_title_tag, $services_summary, $service_link, $services_class, $submit));
    }
}

?>