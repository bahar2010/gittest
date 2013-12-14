<?php

class FaqsController extends Zend_Controller_Action
{

    public function init()
    {
    }
 
 
    public function indexAction()
    {
        $this->view->headTitle()->prepend('General Questions on WinWinHost');
        $data = new Default_Model_DbTable_Faqs();
		
		$value = 'general';
		$where = "faq_category = '$value'";
		$offset = "5";
		$order = "faq_id DESC";

        $faqs =  $data->fetchAll($where,$order);
        $this->view->data = $faqs;
		
		//$adapter = new Zend_Paginator_Adapter_DbSelect($data->select()->order($order));
        //$paginator = new Zend_Paginator($adapter);
        //$paginator->setItemCountPerPage($offset);
        //$paginator->setCurrentPageNumber($this->_getParam('page'));
		//$this->view->data = $paginator;	
    }
	
	
	public function webHostingAction()
    {
        $this->view->headTitle()->prepend('Questions about Web Hosting , Reseller Hosting and Dedicated servers ');
        $data = new Default_Model_DbTable_Faqs();
		
		$value = 'web-hosting';
		$where = "faq_category = '$value'";
		$offset = "5";
		$order = "faq_id DESC";

        $faqs =  $data->fetchAll($where,$order);
        $this->view->data = $faqs;
    }
	
	
		public function domainNamesAction()
    {
        $this->view->headTitle()->prepend('Questions about Domain Names');
        $data = new Default_Model_DbTable_Faqs();
		
		$value = 'domain-names';
		$where = "faq_category = '$value'";
		$offset = "5";
		$order = "faq_id DESC";

        $faqs =  $data->fetchAll($where,$order);
        $this->view->data = $faqs;
    }
	
	public function onlineMarketingAction()
    {
        $this->view->headTitle()->prepend('Questions about Online Marketing');
        $data = new Default_Model_DbTable_Faqs();
		
		$value = 'online-marketing';
		$where = "faq_category = '$value'";
		$offset = "5";
		$order = "faq_id DESC";

        $faqs =  $data->fetchAll($where,$order);
        $this->view->data = $faqs;
    }
	
	
	public function webDesignAction()
    {
        $this->view->headTitle()->prepend('Questions about Web Design and Development');
        $data = new Default_Model_DbTable_Faqs();
		
		$value = 'web-design';
		$where = "faq_category = '$value'";
		$offset = "5";
		$order = "faq_id DESC";

        $faqs =  $data->fetchAll($where,$order);
        $this->view->data = $faqs;
    }
	
	
}