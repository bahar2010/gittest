<?php

class Default_Form_Seo extends Zend_Form
{
	
    public function init()
    {
    	$this->setMethod('post');
    	$this->setAction('#');


    	$name = new Zend_Form_Element_Text('name');
    	$name->setRequired(true)
    		 ->setLabel('Your Name')
        	 ->addFilter('StripTags')
        	 ->addFilter('StringTrim')
        	 ->addValidator('NotEmpty');
		$name->class = "input"; 
		

        $email = new Zend_Form_Element_Text('email');
    	$email->setRequired(true)
    		  ->setLabel('Your Email Address')
        	  ->addFilter('StripTags')
        	  ->addFilter('StringTrim')
        	  ->addValidator('NotEmpty')
        	  ->addValidator('EmailAddress');
		$email->class = "input"; 	  


        $website = new Zend_Form_Element_Text('website');
    	$website->setRequired(true)
    		  ->setLabel('Enter your websites domain name ')
        	  ->addFilter('StripTags')
        	  ->addFilter('StringTrim')
        	  ->addValidator('NotEmpty');
		$website->class = "input"; 	  


        $Keywords = new Zend_Form_Element_Textarea('Keywords');
    	$Keywords->setRequired(true)
    				->setLabel('Enter your keywords you would like your website to rank on the 1st page for.')
        	  		->addFilter('StripTags')
        	  		->setAttrib('cols',40) 
                    ->setAttrib('rows',12)
        	  		->addFilter('StringTrim')
        	  		->addValidator('NotEmpty');
		$Keywords->class = "input"; 	  

        
		
       // $recaptchaKeys = Zend_Registry::get('config.recaptcha');
		
        //$recaptcha = new Zend_Service_ReCaptcha($recaptchaKeys['publickey'], $recaptchaKeys['privatekey'],
               // NULL, array('theme' => 'white'));
				
				


        //$captcha = new Zend_Form_Element_Captcha('captcha',
          //  array(
            //    'label' => 'Type characters in picture ',
             //   'captcha' =>  'ReCaptcha',
              //  'captchaOptions'        => array(
               //     'captcha'   => 'ReCaptcha',
               //     'service' => $recaptcha,
				//	'width' => 500
		 	  
              //  )
         //   )
        //);
		
		


        $submit = new Zend_Form_Element_Submit('submit');
		$submit->class = "submit";


        $this->addElements(array(
        	$name,
        	$email,
        	$website,
        	$Keywords,
        	//$captcha,
        	$submit,

	        ));
    }
}