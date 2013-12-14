<?php

class Dashboard_Form_Slider extends Zend_Form
{
    public function init()
    {
        $this->setName('slider');
        $slider_id = new Zend_Form_Element_Hidden('slider_id');
        $slider_id->addFilter('Int');
		
        $text1 = new Zend_Form_Element_Text('text1');
        $text1->setLabel('Text1')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
        $text2 = new Zend_Form_Element_Text('text2');
        $text2->setLabel('Text2')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
				
		$text3 = new Zend_Form_Element_Text('text3');
        $text3->setLabel('Text3')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
				
		$text4 = new Zend_Form_Element_Text('text4');
        $text4->setLabel('Text4')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
				
		$homepage_link = new Zend_Form_Element_Text('homepage_link');
        $homepage_link->setLabel('homepage_link')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');			
				
		$slider_images = new Zend_Form_Element_File('files');
		$slider_images->setLabel('Select Images for this slider')
				->setIsArray(true)
				->setAttrib('class', 'multi')
				->setAttrib('accept', 'gif|jpg|png')
				->setAttrib('maxlength', 6)
				->setRequired(false)
				->addValidator(new Zend_Validate_File_IsImage);

			

		
		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($slider_id, $text1, $text2, $text3, $text4, $homepage_link, $slider_images, $submit));
    }
}

?>