<?php

class DevelopmentController extends Zend_Controller_Action
{

    public function init()
    {
    }

    

   public function indexAction()
    {
        $this->view->headTitle()->prepend('');
    }
	
	public function webdesignAction()
    {
        $this->view->headTitle()->prepend('Web Designing Services from WinWinHost');
    }
	public function applicationdevelopmentAction()
    {
        $this->view->headTitle()->prepend('Application Development Services from WinWinHost');
    }
	public function mobiledevelopmentAction()
    {
        $this->view->headTitle()->prepend('Mobile Development Services from WinWinHost');
    }
	public function portfolioAction()
    {
        $this->view->headTitle()->prepend('Recent work from WinWinHost');
    }
	
	

	
}