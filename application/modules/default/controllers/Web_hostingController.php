<?php

class Web_hostingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Web Hosting by WinWinHost');
    }
	
	

	
}