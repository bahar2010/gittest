<?php

class DedicatedhostingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('Dedicated hosting from WinWinHost');
    }
	

}