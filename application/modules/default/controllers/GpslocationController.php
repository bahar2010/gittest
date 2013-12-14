<?php

class GpslocationController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Home ');
        $data = new Default_Model_DbTable_News();
        $this->view->data = $data->fetchAll();
    }

    

	
}