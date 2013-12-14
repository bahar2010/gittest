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
        $this->view->headTitle()->prepend('we make Web Design');
    }
	
	public function webApplicationAction()
    {
        $this->view->headTitle()->prepend('We make Web Applications');
    }
	
	public function nativeApplicationAction()
    {
        $this->view->headTitle()->prepend('we make Native Applications');
    }
	
	public function nativeApplicationAction()
    {
        $this->view->headTitle()->prepend('we make Open Source things');
    }

	
}