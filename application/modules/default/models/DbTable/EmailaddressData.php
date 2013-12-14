<?php

class Default_Model_DbTable_EmailaddressData extends Zend_Db_Table_Abstract
{
    protected $_name = 'email_tracking_data';
    protected $_primary = 'id';
	public function getName()
	{
		return $this->_name;
	}
}
