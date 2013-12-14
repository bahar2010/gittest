<?php

class Dashboard_SwpayaccController extends Zend_Controller_Action
{
	const FULL_ROLE = 5;
	
	private static $_instance_member_db = NULL;
	
    public function init()
    {
		$fc = Zend_Controller_Front::getInstance();
        $this->view->baseurl =  $fc->getBaseUrl();
    }
	
	private static function getInstance()
	{
		if (self::$_instance_member_db == NULL)
			self::$_instance_member_db = new Default_Model_DbTable_Members();
		
		return self::$_instance_member_db;
	}

	public function preDispatch()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
        //$this->_helper->layout->disableLayout();
	}
	
	public function indexAction()
	{
		$this->view->headTitle()->prepend('Your Dashboard ');
        $id = Zend_Auth::getInstance()->getIdentity()->member_id;

		
		if ($this->getRequest () ->isPost())
		{	
			if (0)
			{
				$paypalacc = $this->getRequest()->getParam('paypalacc', null);
			
				if ($paypalacc == null)
				{
					$this->view->response = "paypal account is null\n";
					return;
				}
			}
			$this->processPaypal();
			
			$role = array('member_role' => self::FULL_ROLE);
			$where['member_id = ?'] = $id;
			self::getInstance()->update($role, $where);	
			
			$authData = Zend_Auth::getInstance()->getIdentity();
			$authData->member_role = self::FULL_ROLE;
			
			//$this->_redirect("/dashboard/showhword");
		}
		
	}
	
	private function processPaypal()
	{	
		// Live URL: https://api-3t.paypal.com/nvp
		// Test URL: https://api-3t.sandbox.paypal.com/nvp
		$url = 'https://api-3t.paypal.com/nvp';

		$amount = 10.00; // Obviously, we would sum up the contents of some cart to fill in this value.
		$credit_card_type = $this->getRequest()->getParam('credit_card_type');
		$credit_card_number = $this->getRequest()->getParam('credit_card_number');
		$expiration_month = $this->getRequest()->getParam('expiration_month');
		$expiration_year = $this->getRequest()->getParam('expiration_year');
		$cvv2 = $this->getRequest()->getParam('cvv2');

		$first_name = $this->getRequest()->getParam('first_name');
		$last_name = $this->getRequest()->getParam('last_name');
		$address1 = $this->getRequest()->getParam('address1');
		$address2 = $this->getRequest()->getParam('address2');
		$city = $this->getRequest()->getParam('city');
		$state = $this->getRequest()->getParam('state');
		$zip = $this->getRequest()->getParam('zip');

		$country = 'US'; // Assuming we are only accepting transactions within the United States.
		$currency_code = 'USD'; // Assuming we are using the United States Dollar
		$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP Address, assuming we are in a LAMP environment

		// Create an instance of our PayPal NVP client
		$client = new Zend_Paypal_Client($url);

		// Send our API request!
		$result = $client->doDirectPayment(
			$amount,
			$credit_card_type,
			$credit_card_number,
			$expiration_month,
			$expiration_year,
			$cvv2,
			$first_name,
			$last_name,
			$address1,
			$address2,
			$city,
			$state,
			$zip,
			$country,
			$currency_code,
			$ip_address);

		// Remember to store the transaction ID! You'll need it 
		// to lookup the transaction details. For now, let's just
		// display the results.
		echo $result->getBody();	
	}
}