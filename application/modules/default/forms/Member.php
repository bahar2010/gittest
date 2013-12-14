<?php

class Default_Form_Member extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $accountTypes = array(
			2 => 'Free',
            //3 => 'Family Account',
           // 5 => 'Business Account'
        );

        $accountType = new Zend_Form_Element_Select('account_type');
        $accountType->setLabel('Account type')
				//->setAttrib('onchange', 'ajaxAddField();')
                ->addMultiOptions($accountTypes);

		
		//$city = new Zend_Form_Element_Text('city');
        //$city->setLabel('City')
        	//->setRequired(true)
        	//->addFilter('StripTags')
        	//->addFilter('StringTrim')
        	//->addValidator('NotEmpty');
			
			
		//$fullname = new Zend_Form_Element_Text('fullname');
        //$fullname->setLabel('Enter your Full Name')
        	//->setRequired(true)
        	//->addFilter('StripTags')
        	//->addFilter('StringTrim')
        	//->addValidator('NotEmpty');
				
			
			
		//$familymembers = new Zend_Form_Element_Text('familymembers');
        //$familymembers->setLabel('How many Family members you have ?')
        	//->setRequired(true)
        	//->addFilter('StripTags')
        	//->addFilter('StringTrim')
        	//->addValidator('NotEmpty');
			

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty')
			->addValidator('EmailAddress',  TRUE  )
			->addValidator(new Zend_Validate_Db_NoRecordExists(
						'members',
						'member_email'                   
                        ), TRUE );
						
		$email->addErrorMessage('The E-mail is required!'); 
        
		$email->addValidator(new Zend_Validate_Db_NoRecordExists(
						'members',
						'member_email'                   
                        ), TRUE );
		$email->addErrorMessage('This E-mail already exists.');


        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty')
			->addValidator(new Zend_Validate_Db_NoRecordExists(
						'members',
						'member_username'                   
                        ), TRUE );
        	
	
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		$password->addErrorMessage('Password is required!');

        
        $register = new Zend_Form_Element_Submit('register', 'Sign Up!');
        
        $this->addElements(array(
            $username,
            $email,
            $accountType,
            $password, 
			//$city,
			//$familymembers,
			//$fullname,
            $register
        ));
       	
    }


}

