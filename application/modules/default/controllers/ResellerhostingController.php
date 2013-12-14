<?php

class ResellerhostingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Reseller Hosting from WinWinHost');
    }
	

}