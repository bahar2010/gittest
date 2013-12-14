<?php

class Dashboard_Model_DbTable_Loads extends Zend_Db_Table_Abstract
{
    protected $_name = 'loads';
    protected $_primary = 'id';


    public function addToLoads($data)
    {
//        $id = array(
//            'owner' => Zend_Auth::getInstance()->getIdentity()->member_id
//                );
            
        //$this->insert($id);
        $this->insert($data);
        return true;
        
    }

}

