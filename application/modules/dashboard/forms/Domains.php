<?php

class Dashboard_Form_Domains extends Zend_Form
{
    public function init()
    {
        //news ext, news price
        $ext = new Zend_Form_Element_Text('ext');
        $ext->setLabel('Domain Extension')
              ->setRequired(true)
              ->addFilter(new Zend_Filter_Alpha(true))
              ->setValidators(array('NotEmpty'));
		$ext->class = "wpcf7"; 

        $price = new Zend_Form_Element_Text('price');
        $price->setRequired(true)
             ->setLabel('First Year Price')
             ->setValidators(array('NotEmpty'));
		$price->class = "wpcf7"; 
		
		$price_renew = new Zend_Form_Element_Text('price_renew');
        $price_renew->setRequired(true)
             ->setLabel('Renew Price')
             ->setValidators(array('NotEmpty'));
		$price_renew->class = "wpcf7"; 
		
		$price_2years = new Zend_Form_Element_Text('price_2years');
        $price_2years->setRequired(true)
             ->setLabel('per unit cost for 2 years')
             ->setValidators(array('NotEmpty'));
		$price_2years->class = "wpcf7"; 
		
		$price_3years = new Zend_Form_Element_Text('price_3years');
        $price_3years->setRequired(true)
             ->setLabel('per unit cost for 3 years')
             ->setValidators(array('NotEmpty'));
		$price_3years->class = "wpcf7"; 
		
		$price_5years = new Zend_Form_Element_Text('price_5years');
        $price_5years->setRequired(true)
             ->setLabel('per unit cost for 5 years')
             ->setValidators(array('NotEmpty'));
		$price_5years->class = "wpcf7";
		
		$price_10years = new Zend_Form_Element_Text('price_10years');
        $price_10years->setRequired(true)
             ->setLabel('per unit cost for 10 years')
             ->setValidators(array('NotEmpty'));
		$price_10years->class = "wpcf7";
		
		
        $submit = new Zend_Form_Element_Submit('submit', 'Create');
		$submit->class = "wpcf7-submit"; 

        $this->addElements(array(
            $ext,
            $price,
			$price_renew,
			$price_2years,
			$price_3years,
			$price_5years,
			$price_10years,
            $submit
        ));
    }
}
