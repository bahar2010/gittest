<?php

class MarketingController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $this->view->headTitle()->prepend('');
    }
	
	public function seoAction()
    {
        $this->view->headTitle()->prepend('Search Engine Optimization');
    }
	public function managedPpcCampaignsAction()
    {
        $this->view->headTitle()->prepend('Managed PPC Campaigns');
    }
	public function affiliateSystemsAction()
    {
        $this->view->headTitle()->prepend('Affiliate Systems');
    }
	public function emailMarketingAction()
    {
        $this->view->headTitle()->prepend('Email Marketing');
    }
	

	
}