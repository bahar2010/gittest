<?php

class Dashboard_Model_DbTable_Homepageprojects extends Zend_Db_Table_Abstract
{
    protected $_name = 'homepageprojects';
	protected $_primary = 'homepageproject_id';
  
public function getHomepageproject($homepageproject_id) 
    {
        $homepageprojects_id = (int)$homepageproject_id;
        $row = $this->fetchRow('homepageproject_id = ' . $homepageproject_id);
        if (!$row) {
            throw new Exception("Could not find row $homepageproject_id");
        }
        return $row->toArray();    
    }

public function addHomepageproject($homepageproject_id, $project_imgpath_thumb, $project_imgpath_large, $project_title, $project_summary, $project_link)
    {
        $data = array(
			'homepageproject_id' => $homepageproject_id,
			'project_imgpath_thumb' => $project_imgpath_thumb,
			'project_imgpath_large' => $project_imgpath_large,
            'project_title' => $project_title,
            'project_summary' => $project_summary,
			'project_link' => $project_link,
				);
        $this->insert($data);
    }

public function updateHomepageproject($homepageproject_id, $project_imgpath_thumb, $project_imgpath_large, $project_title, $project_summary, $project_link)
    {
        $data = array(
            	'homepageproject_id' => $homepageproject_id,
				'project_imgpath_thumb' => $project_imgpath_thumb,
				'project_imgpath_large' => $project_imgpath_large,
            	'project_title' => $project_title,
            	'project_summary' => $project_summary,
				'project_link' => $project_link,
			       );
        $this->update($data, 'homepageproject_id = '. (int)$homepageproject_id);
    }
public function deleteHomepageproject($id)
    {
        $this->delete('homepageproject_id =' . (int)$id);
    }
}

?>

