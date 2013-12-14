<?php

class Dashboard_Form_Faqs extends Zend_Form
{
    public function init()
    {
        //news title, news text
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Question')
              ->setRequired(true)
              ->addFilter(new Zend_Filter_Alpha(true))
              ->setValidators(array('NotEmpty'));
		$title->class = "wpcf7"; 

        $text = new Zend_Form_Element_Textarea('text');
        $text->setRequired(true)
             ->setLabel('Answer')
             ->addFilter(new Zend_Filter_Alpha(true))
             ->setValidators(array('NotEmpty'));
		$text->class = "span8"; 
		
		$category = new Zend_Form_Element_Text('category');
        $category->setLabel('Category')
              ->setRequired(true)
              ->addFilter(new Zend_Filter_Alpha(true))
              ->setValidators(array('NotEmpty'));
		$category->class = "wpcf7"; 

        $submit = new Zend_Form_Element_Submit('submit', 'Create');
		$submit->class = "wpcf7-submit"; 

        $this->addElements(array(
            $title,
			$category,
            $text,
            $submit
        ));
    }
}
