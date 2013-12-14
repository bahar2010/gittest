<?php

class Default_Model_DbTable_CalltrackingData extends Zend_Db_Table_Abstract
{
    protected $_name = 'call_tracking_data';
    protected $_primary = 'id';
	public function getName()
	{
		return $this->_name;
	}
}
