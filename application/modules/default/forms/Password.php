<?php
//validation
class Default_Form_Password extends Zend_Form
{
	public function init()
	{
		$this->addElement('password', 'current', array(
			'label' => 'Current Password'
		));
		
		$this->addElement('password', 'new', array(
			'label' => 'New Password'
		));
		
		$this->addElement('submit', 'submit', 'Change');
	}
}