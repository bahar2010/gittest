<?php
class Default_Model_DbTable_domainPrices extends Zend_Db_Table_Abstract {
	protected $_name = 'domain_prices';
    protected $_primary = 'id';
	
	function getAllDomainPrices() {
		$res = $this->fetchAll();
		$result = array();
		foreach ($res as $row) {
			$result[$row->ext] = array(
				'price'  => $row->price,
				'price_2years' => $row->price_2years,
				'price_3years' => $row->price_3years,
				'price_5years' => $row->price_5years,
				'price_10years' => $row->price_10years
			);		
		}
		return $result;
	}
	
	function getAllSupportedDomains() {
		$res = $this->fetchAll();
		$result = array();
		foreach ($res as $row) {
			$result[] = $row->ext;
		}
		return $result;
	}	
}

?>
