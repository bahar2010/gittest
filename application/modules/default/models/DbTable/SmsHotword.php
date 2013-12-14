<?php

class Default_Model_DbTable_SmsHotword extends Zend_Db_Table_Abstract
{
    protected $_name = 'sms_hotwords';
    protected $_primary = 'id';
	public function getName()
	{
		return $this->_name;
	}
}
