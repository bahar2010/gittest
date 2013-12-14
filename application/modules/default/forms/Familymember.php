<?php

class Default_Form_Familymember extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $accountTypes = array(
			2 => 'Free',
            3 => 'Family Account',
            5 => 'Business Account'
        );

        $accountType = new Zend_Form_Element_Select('account_type');
        $accountType->setLabel('Account type')
				//->setAttrib('onchange', 'ajaxAddField();')
                ->addMultiOptions($accountTypes)
				->setAttrib('disabled', 'disabled');

		
		$firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setLabel('First Name')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
			
			
		$lastname = new Zend_Form_Element_Text('lastname');
        $lastname->setLabel('Last Name')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
				
			
			
		$addressline1 = new Zend_Form_Element_Text('addressline1');
        $addressline1->setLabel('Address, Line 1')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		

		
		$addressline2 = new Zend_Form_Element_Text('addressline2');
        $addressline2->setLabel('Address, Line 2')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');	
		
		
		$city = new Zend_Form_Element_Text('city');
        $city->setLabel('City')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');

		
		
		$state = new Zend_Form_Element_Text('state');
        $state->setLabel('State')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		

		$zip = new Zend_Form_Element_Text('zip');
        $zip->setLabel('Zip')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		$cardtype = new Zend_Form_Element_Text('cardtype');
        $cardtype->setLabel('Card Type')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
				
		$cardnumber = new Zend_Form_Element_Text('cardnumber');
        $cardnumber->setLabel('Card number')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
		
		
		$amount = new Zend_Form_Element_Text('amount');
        $amount->setLabel('Amount')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty')
			->setAttrib('disabled', 'disabled');
		
		
		$expiration_month = new Zend_Form_Element_Text('expiration_month');
        $expiration_month->setLabel('Expiration month')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');
			
			
		$expiration_year = new Zend_Form_Element_Text('expiration_year');
        $expiration_year->setLabel('Expiration year')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty');	
			
		
		
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
			$firstname,
			$lastname,
			$addressline1,
			$addressline2,			
			$city,
			$state,
			$zip,
			$cardtype,
			$cardnumber,
			$expiration_month,
			$expiration_year,	
			$amount,
            $register
        ));
       	
    }


}

