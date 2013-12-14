<?php

class Default_Model_DbTable_HotwordData extends Zend_Db_Table_Abstract
{
    protected $_name = 'hot_worlds';
    protected $_primary = 'id';
	public function getName()
	{
		return $this->_name;
	}
}
