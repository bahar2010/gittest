<?php

class Default_Model_DbTable_Restfull extends Zend_Db_Table_Abstract
{
    protected $_name = 'restfull';
    protected $_primary = 'id';
	public function getName()
	{
		return $this->_name;
	}
}
