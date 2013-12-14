<?php

class FindController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Find Jobs ');
    }
	

	public function jobAction()
    {
        $this->view->headTitle()->prepend('The Job');
    }
	
}