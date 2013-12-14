<?php

class LocationController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function locationAction()
    {
        $this->view->headTitle()->prepend('Current Location ');
        $data = new Default_Model_DbTable_Location();
        $this->view->data = $data->fetchAll();
		
    }

    

	
}