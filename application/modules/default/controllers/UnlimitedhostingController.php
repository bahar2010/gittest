<?php

class UnlimitedhostingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Unlimited Hosting from WinWinHost');
    }
	

}