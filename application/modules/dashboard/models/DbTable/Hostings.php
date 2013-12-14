<?php

class Dashboard_Model_DbTable_Hostings extends Zend_Db_Table_Abstract
{
    protected $_name = 'hostings';
	protected $_primary = 'hosting_id';
  
public function getHosting($hosting_id) 
    {
        $hosting_id = (int)$hosting_id;
        $row = $this->fetchRow('hosting_id = ' . $hosting_id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();    
    }

public function addHosting($hosting_id, $homepage_hosting_type, $starting_price_dollars, $starting_price_cents, $hosting_link, $hosting_class)
    {
        $data = array(
			'hosting_id' => $hosting_id,
            'homepage_hosting_type' => $homepage_hosting_type,
            'starting_price_dollars' => $starting_price_dollars,
		 'starting_price_cents' => $starting_price_cents,
		 'hosting_link' => $hosting_link,
		 'hosting_class' => $hosting_class,
				);
        $this->insert($data);
    }

public function updateHosting($hosting_id, $homepage_hosting_type, $starting_price_dollars, $starting_price_cents, $hosting_link, $hosting_class)
    {
        $data = array(
            'hosting_id' => $hosting_id,
            'homepage_hosting_type' => $homepage_hosting_type,
            'starting_price_dollars' => $starting_price_dollars,
		 'starting_price_cents' => $starting_price_cents,
		 'hosting_link' => $hosting_link,
		 'hosting_class' => $hosting_class,
			       );
        $this->update($data, 'hosting_id = '. (int)$hosting_id);
    }

public function deleteHosting($hosting_id)
    {
        $this->delete('hosting_id =' . (int)$hosting_id);
    }
}

?>

