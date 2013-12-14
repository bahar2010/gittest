<?php

class Default_Model_DbTable_Child extends Zend_Db_Table_Abstract
{
    protected $_name = 'childs_userid';
    protected $_primary = 'id';
	public function getName()
	{
		return $this->_name;
	}
}
