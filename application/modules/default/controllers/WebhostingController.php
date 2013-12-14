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
	
	

	
}