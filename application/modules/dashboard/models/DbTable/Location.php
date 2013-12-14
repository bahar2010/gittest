<?php

class Dashboard_Model_DbTable_Location extends Zend_Db_Table_Abstract
{
    protected $_name = 'location';
    protected $_primary = 'user_id';

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
