<?php

class FindController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Find Cool Jobs');
    }
	
	public function webDesignAction()
    {
        $this->view->headTitle()->prepend('we make Web Design');
    }
	
	public function webApplicationsAction()
    {
        $this->view->headTitle()->prepend('We make Web Applications');
    }
	
	public function nativeApplicationsAction()
    {
        $this->view->headTitle()->prepend('we make Native Applications');
    }
	
	public function openSourceAction()
    {
        $this->view->headTitle()->prepend('we make Open Source things');
    }

	
}