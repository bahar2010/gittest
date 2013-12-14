<?php

class HowitworksController extends Zend_Controller_Action
{

    public function init()
    {
    }

    

    public function howitworksAction()
    {
        $this->view->headTitle()->prepend('How System Works');
    }
	
	
}