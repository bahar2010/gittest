<?php

class Dashboard_Model_DbTable_Sliders extends Zend_Db_Table_Abstract
{
    protected $_name = 'sliders';
	protected $_primary = 'slider_id';
	
public function getSlider($id) 
    {
        $id = (int)$id;
        $row = $this->fetchRow('slider_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();    
    }
	
public function addSlider($slider_id, $text1, $text2, $text3, $text4, $homepage_link, $imagepath)
    {
        $data = array(
			'slider_id' => $slider_id,
            'homepage_slider_text1' => $text1,
            'homepage_slider_text2' => $text2,
			'homepage_slider_text3' => $text3,
			'homepage_slider_text4' => $text4,
			'homepage_link' => $homepage_link,
			'imagepath' => $imagepath,
		);
        $this->insert($data);
    }
public function updateSlider($id, $text1, $text2, $text3, $text4, $homepage_link, $imagepath)
    {
        $data = array(
            'homepage_slider_text1' => $text1,
            'homepage_slider_text2' => $text2,
			'homepage_slider_text3' => $text3,
			'homepage_slider_text4' => $text4,
			'homepage_link' => $homepage_link,
			'imagepath' => $imagepath,
        );
        $this->update($data, 'slider_id = '. (int)$id);
    }
public function deleteSlider($id)
    {
        $this->delete('slider_id =' . (int)$id);
    }
	
}	
?>

