<?php

class OurController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function privacypolicyAction()
    {
        $this->view->headTitle()->prepend('WinWinHost : Privacy Policy');
    }
	
	public function termsAction()
    {
        $this->view->headTitle()->prepend('WinWinHost : Terms and COnditions');
    }
	

}