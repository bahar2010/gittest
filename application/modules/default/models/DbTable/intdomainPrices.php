<?php
class Default_Model_DbTable_intdomainPrices extends Zend_Db_Table_Abstract {
	protected $_name = 'intdomain_prices';
    protected $_primary = 'id';
	
	function getAllDomainPrices() {
		$res = $this->fetchAll();
		$result = array();
		foreach ($res as $row) {
			$result[$row->ext][$row->duration] = $row->price;
		}
		return $result;
	}	
}

?>
