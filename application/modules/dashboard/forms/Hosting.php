<?php

class Dashboard_Form_Hosting extends Zend_Form
{
    public function init()
    {
        $this->setName('hosting');
        $hosting_id = new Zend_Form_Element_Hidden('hosting_id');
        $hosting_id->addFilter('Int');
		
        $homepage_hosting_type = new Zend_Form_Element_Text('homepage_hosting_type');
        $homepage_hosting_type->setLabel('homepage_hosting_type')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
        $starting_price_dollars = new Zend_Form_Element_Text('starting_price_dollars');
        $starting_price_dollars->setLabel('starting_price_dollars')
				->addFilter('Int');
				
		$starting_price_cents = new Zend_Form_Element_Text('starting_price_cents');
        $starting_price_cents->setLabel('starting_price_cents')
				->addFilter('Int');
				
		$hosting_link = new Zend_Form_Element_Text('hosting_link');
        $hosting_link->setLabel('hosting_link')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');

		$hosting_class = new Zend_Form_Element_Text('hosting_class');
		$hosting_class->setLabel('Make this hosting active? Enter - yes or no')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');	
						
		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($hosting_id, $homepage_hosting_type, $starting_price_dollars, $starting_price_cents, $hosting_link, $hosting_class, $submit));
    }
}

?>