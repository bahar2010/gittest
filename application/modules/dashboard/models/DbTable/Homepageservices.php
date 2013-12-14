<?php

class Dashboard_Model_DbTable_Homepageservices extends Zend_Db_Table_Abstract
{
    protected $_name = 'homepageservices';
	protected $_primary = 'services_id';
	
public function getHomepageservice($id) 
    {
        $id = (int)$id;
        $row = $this->fetchRow('services_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();    
    }
public function addHomepageservice($services_id, $services_title, $services_title_tag, $services_summary, $service_link, $services_class)
    {
        $data = array(
			'services_id' => $services_id,
            'services_title' => $services_title,
            'services_title_tag' => $services_title_tag,
			'services_summary' => $services_summary,
			'service_link' => $service_link,
			'services_class' => $services_class,
		);
        $this->insert($data);
    }
public function updateHomepageservice($services_id, $services_title, $services_title_tag, $services_summary, $service_link, $services_class)
    {
        $data = array(
            'services_id' => $services_id,
            'services_title' => $services_title,
            'services_title_tag' => $services_title_tag,
			'services_summary' => $services_summary,
			'service_link' => $service_link,
			'services_class' => $services_class,
        );
        $this->update($data, 'services_id = '. (int)$services_id);
    }
public function deleteHomepageservice($services_id)
    {
        $this->delete('services_id =' . (int)$services_id);
    }
	
}
	
?>

