<?php

class hostingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    

    public function webHostingAction()
    {
        $this->view->headTitle()->prepend('Web Hosting by WinWinHost');
    }
	
	public function sharedHostingAction()
    {
        $this->view->headTitle()->prepend('');
    }
	
	public function resellerHostingAction()
    {
        $this->view->headTitle()->prepend('');
    }
	
	public function dedicatedSeverAction()
    {
        $this->view->headTitle()->prepend('');
    }
	

	
}