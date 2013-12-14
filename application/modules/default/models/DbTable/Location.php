<?php

class Default_Model_DbTable_Location extends Zend_Db_Table_Abstract
{
    protected $_name = 'members_location';
    protected $_primary = 'members_location_id';

     public function getLocation($id){
        
       try { 
            $row=$this->find($id)->current();
           
            
            return $row->stock;
        }
    	catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
        
    }
}
