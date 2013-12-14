<?php
class Default_Model_DbTable_Projects extends Zend_Db_Table_Abstract {
	protected $_name = 'projects';
    protected $_primary = 'id';
	
	public function project_exists($projectname) {
		if (empty($projectname)) {
			return false;
		}
		
		$select = $this->select()->from($this->_name)->where('name =?', $projectname);
		if ($this->fetchRow($select)) {
			return true;
		} else {
			return false;
		}
	}
}

?>
