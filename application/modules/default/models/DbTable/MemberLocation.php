<?php

class Default_Model_DbTable_MemberLocation extends Zend_Db_Table_Abstract
{
    protected $_name = 'members_location';
    protected $_primary = 'members_location_id';
	public function getName()
	{
		return $this->_name;
	}
}
