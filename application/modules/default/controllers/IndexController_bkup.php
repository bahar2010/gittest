<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->append('Web Hositng, Web Design, Web Development, App Development');
        $data = new Default_Model_DbTable_News();
        $this->view->data = $data->fetchAll();
    }

   
	
}