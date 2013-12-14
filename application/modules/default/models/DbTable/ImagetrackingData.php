<?php

class Default_Model_DbTable_ImagetrackingData extends Zend_Db_Table_Abstract
{
    protected $_name = 'image_tracking_data';
    protected $_primary = 'id';
	public function getName()
	{
		return $this->_name;
	}
}
