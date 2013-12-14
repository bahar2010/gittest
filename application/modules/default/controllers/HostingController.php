<?php

class hostingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    
    public function indexAction()
    {
        $this->view->headTitle()->prepend('Hosting Services by WinWinHost');
    }
    public function webHostingAction()
    {
        $this->view->headTitle()->prepend('Web Hosting by WinWinHost');
    }
	
	public function resellerHostingAction()
    {
        $this->view->headTitle()->prepend('');
    }
	
	public function dedicatedServerAction()
    {
        $this->view->headTitle()->prepend('');
    }
	

	
}