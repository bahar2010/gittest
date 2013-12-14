<?php

class HuntController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Hunt ');
    }
	
	 public function workerAction()
    {
        $this->view->headTitle()->prepend(' Hunt Workers ');
    }

	
}