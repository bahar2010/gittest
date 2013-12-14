<?php

class Dashboard_Form_Domain extends Zend_Form
{
    public function init()
    {
        $this->setName('domain');
        $domain_id = new Zend_Form_Element_Hidden('domain_id');
        $domain_id->addFilter('Int');
		
        $Extension = new Zend_Form_Element_Text('Extension');
        $Extension->setLabel('Extension')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
        $Dollars = new Zend_Form_Element_Text('Dollars');
        $Dollars->setLabel('Dollars')
				->addFilter('Int');
				
		$Cents = new Zend_Form_Element_Text('Cents');
        $Cents->setLabel('Cents')
				->addFilter('Int');
						
		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($domain_id, $Extension, $Dollars, $Cents, $submit));
    }
}

?>