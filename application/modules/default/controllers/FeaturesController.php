<?php

class MakingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend(' ');
    }
	
	public function webDesignAction()
    {
        $this->view->headTitle()->prepend(' ');
    }
	
	public function webApplicationAction()
    {
        $this->view->headTitle()->prepend(' ');
    }
	
	public function nativeApplicationAction()
    {
        $this->view->headTitle()->prepend(' ');
    }
	

	
}