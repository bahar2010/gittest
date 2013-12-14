<?php

class Dashboard_Model_DbTable_Domains extends Zend_Db_Table_Abstract
{
    protected $_name = 'domains';
	protected $_primary = 'domain_id';
  
public function getDomain($id) 
    {
        $id = (int)$id;
        $row = $this->fetchRow('domain_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
		
        return $row->toArray();    
    }
	
public function addDomain($domain_id, $homepage_domain_extension, $homepage_domain_price_dollars, $homepage_domain_price_cents)
    {
        $data = array(
			'domain_id' => $domain_id,
			'homepage_domain_extension' => $homepage_domain_extension,
            'homepage_domain_price_dollars' => $homepage_domain_price_dollars,
            'homepage_domain_price_cents' => $homepage_domain_price_cents,
				);
        $this->insert($data);
    }

public function updateDomain($domain_id, $homepage_domain_extension, $homepage_domain_price_dollars, $homepage_domain_price_cents)
    {
        $data = array(
            'domain_id' => $domain_id,
			'homepage_domain_extension' => $homepage_domain_extension,
            'homepage_domain_price_dollars' => $homepage_domain_price_dollars,
            'homepage_domain_price_cents' => $homepage_domain_price_cents,

        );
        $this->update($data, 'domain_id = '. (int)$domain_id);
    }
public function deleteDomain($domain_id)
    {
        $this->delete('domain_id =' . (int)$domain_id);
    }
}

?>

