<?php

class Default_Model_DbTable_MemberId extends Zend_Db_Table_Abstract
{
    protected $_name = 'members';
    protected $_primary = 'member_id';
	public function getName()
	{
		return $this->_name;
	}
}
