<?php

class Default_Form_Login extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel('Username:')
		         ->setRequired(true)
		         ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('NotEmpty');
				 
                 
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('NotEmpty');
                 
        $login = new Zend_Form_Element_Submit('login', 'Login!');
		$login->class ="btn btn-info right";
        
        $this->addElements(array(
            $username,
            $password, 
            $login
        ));
	}
}